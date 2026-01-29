<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PIMController extends Controller
{
    /**
     * Get allowed enum values for custom_fields.data_type from the database.
     */
    private function getCustomFieldTypes(): array
    {
        $row = DB::selectOne("SHOW COLUMNS FROM custom_fields WHERE Field = 'data_type'");
        if (!$row) {
            return [];
        }

        // MariaDB/MySQL returns Type or type depending on driver/version
        $typeDef = $row->Type ?? ($row->type ?? null);
        if (!$typeDef || !str_starts_with(strtolower($typeDef), 'enum(')) {
            return [];
        }

        // Strip enum( ... ) and split values
        $inner = substr($typeDef, 5, -1); // remove "enum(" prefix and trailing ")"
        $parts = explode(',', $inner);

        $options = [];
        foreach ($parts as $part) {
            $value = trim($part, " '\"");
            if ($value !== '') {
                $options[] = $value;
            }
        }

        return $options;
    }

    /**
     * Find the first ENUM column on a table and return its name + allowed values.
     *
     * Used to power dropdowns for configuration screens (e.g. reporting_methods).
     */
    private function getFirstEnumColumnMeta(string $table): ?array
    {
        $columns = DB::select("SHOW COLUMNS FROM {$table}");
        if (!$columns) {
            return null;
        }

        foreach ($columns as $col) {
            $fieldName = $col->Field ?? ($col->field ?? null);
            $typeDef   = $col->Type ?? ($col->type ?? null);
            if (!$fieldName || !$typeDef) {
                continue;
            }

            $lower = strtolower($typeDef);
            if (!str_starts_with($lower, 'enum(')) {
                continue;
            }

            $inner = substr($typeDef, 5, -1);
            $parts = explode(',', $inner);
            $options = [];
            foreach ($parts as $part) {
                $value = trim($part, " '\"");
                if ($value !== '') {
                    $options[] = $value;
                }
            }

            if (!empty($options)) {
                return [
                    'field'   => $fieldName,
                    'options' => $options,
                ];
            }
        }

        return null;
    }
    public function index()
    {
        return redirect()->route('pim.employee-list');
    }

    public function employeeList()
    {
        $employees = DB::table('employees')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employment_statuses', 'employees.employment_status_id', '=', 'employment_statuses.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->leftJoin('employees as supervisors', 'employees.supervisor_id', '=', 'supervisors.id')
            ->select(
                'employees.id',
                'employees.employee_number as employee_number',
                'employees.first_name',
                'employees.last_name',
                'job_titles.name as job_title',
                'employment_statuses.name as employment_status',
                'organization_units.name as sub_unit',
                DB::raw("COALESCE(supervisors.display_name, '') as supervisor")
            )
            ->orderBy('employees.employee_number')
            ->get();

        return view('pim.employee-list', compact('employees'));
    }

    public function addEmployee()
    {
        return view('pim.add-employee');
    }

    public function reports()
    {
        $reports = DB::table('employee_qualifications')
            ->join('employees', 'employee_qualifications.employee_id', '=', 'employees.id')
            ->join('qualifications', 'employee_qualifications.qualification_id', '=', 'qualifications.id')
            ->select(
                DB::raw('DISTINCT qualifications.name as name')
            )
            ->orderBy('name')
            ->get();

        return view('pim.reports', compact('reports'));
    }

    // Configuration methods
    public function optionalFields()
    {
        // Load current configuration from pim_optional_fields table
        $rows = DB::table('pim_optional_fields')
            ->whereIn('field_name', [
                'deprecated_fields',
                'ssn',
                'sin',
                'us_tax_exemptions',
            ])
            ->get()
            ->keyBy('field_name');

        $showDeprecated = (bool) optional($rows->get('deprecated_fields'))->is_visible ?? true;
        $showSSN        = (bool) optional($rows->get('ssn'))->is_visible ?? true;
        $showSIN        = (bool) optional($rows->get('sin'))->is_visible ?? false;
        $showTax        = (bool) optional($rows->get('us_tax_exemptions'))->is_visible ?? false;

        return view('pim.configuration.optional-fields', compact(
            'showDeprecated',
            'showSSN',
            'showSIN',
            'showTax'
        ));
    }

    /**
     * Persist PIM optional field configuration.
     */
    public function saveOptionalFields(Request $request)
    {
        $data = $request->validate([
            'show_deprecated' => ['nullable', 'in:0,1'],
            'show_ssn'        => ['nullable', 'in:0,1'],
            'show_sin'        => ['nullable', 'in:0,1'],
            'show_tax'        => ['nullable', 'in:0,1'],
        ]);

        $now = now();

        $map = [
            'deprecated_fields'  => [
                'field_label' => 'Show Deprecated Fields',
                'screen'      => 'personal_details',
                'value'       => isset($data['show_deprecated']) ? (int) $data['show_deprecated'] : 0,
            ],
            'ssn' => [
                'field_label' => 'Show SSN field in Personal Details',
                'screen'      => 'personal_details',
                'value'       => isset($data['show_ssn']) ? (int) $data['show_ssn'] : 0,
            ],
            'sin' => [
                'field_label' => 'Show SIN field in Personal Details',
                'screen'      => 'personal_details',
                'value'       => isset($data['show_sin']) ? (int) $data['show_sin'] : 0,
            ],
            'us_tax_exemptions' => [
                'field_label' => 'Show US Tax Exemptions menu',
                'screen'      => 'personal_details',
                'value'       => isset($data['show_tax']) ? (int) $data['show_tax'] : 0,
            ],
        ];

        foreach ($map as $fieldName => $config) {
            DB::table('pim_optional_fields')->updateOrInsert(
                [
                    'field_name' => $fieldName,
                    'screen'     => $config['screen'],
                ],
                [
                    'field_label' => $config['field_label'],
                    'is_required' => 0,
                    'is_visible'  => $config['value'],
                    'updated_at'  => $now,
                    'created_at'  => $now,
                ]
            );
        }

        return redirect()
            ->route('pim.configuration.optional-fields')
            ->with('status', 'Optional fields updated.');
    }

    public function customFields()
    {
        $customFields = DB::table('custom_fields')
            ->select('id', 'name', 'module as screen', 'data_type as field_type')
            ->orderBy('name')
            ->get();
        
        $dataTypeOptions = $this->getCustomFieldTypes();
        
        return view('pim.configuration.custom-fields', compact(
            'customFields',
            'dataTypeOptions'
        ));
    }

    /**
     * Store a new custom field.
     */
    public function storeCustomField(Request $request)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'screen'     => ['nullable', 'string', 'max:100'],
            'field_type' => ['required', 'string', 'max:50'],
        ]);

        // Normalize field type to match allowed values in DB enum
        $rawType = strtolower($data['field_type']);
        $allowedTypes = array_map('strtolower', $this->getCustomFieldTypes());
        $normalizedType = in_array($rawType, $allowedTypes, true)
            ? $rawType
            : (reset($allowedTypes) ?: 'text');

        DB::table('custom_fields')->insert([
            'name'       => $data['name'],
            'label'      => $data['name'],          // use name as label by default
            'module'     => $data['screen'] ?? null,
            'data_type'  => $normalizedType,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pim.configuration.custom-fields')
            ->with('status', 'Custom field added.');
    }

    /**
     * Update an existing custom field.
     */
    public function updateCustomField(Request $request, int $id)
    {
        $data = $request->validate([
            'name'       => ['required', 'string', 'max:255'],
            'screen'     => ['nullable', 'string', 'max:100'],
            'field_type' => ['required', 'string', 'max:50'],
        ]);

        $rawType = strtolower($data['field_type']);
        $allowedTypes = array_map('strtolower', $this->getCustomFieldTypes());
        $normalizedType = in_array($rawType, $allowedTypes, true)
            ? $rawType
            : (reset($allowedTypes) ?: 'text');

        DB::table('custom_fields')
            ->where('id', $id)
            ->update([
                'name'       => $data['name'],
                'label'      => $data['name'],      // keep label in sync with name
                'module'     => $data['screen'] ?? null,
                'data_type'  => $normalizedType,
                'updated_at' => now(),
            ]);

        return redirect()->route('pim.configuration.custom-fields')
            ->with('status', 'Custom field updated.');
    }

    /**
     * Delete a custom field.
     */
    public function deleteCustomField(int $id)
    {
        DB::table('custom_fields')->where('id', $id)->delete();

        return redirect()->route('pim.configuration.custom-fields')
            ->with('status', 'Custom field deleted.');
    }

    /**
     * Bulk delete custom fields.
     */
    public function bulkDeleteCustomFields(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('custom_fields')->whereIn('id', $ids)->delete();
        }

        return redirect()->route('pim.configuration.custom-fields')
            ->with('status', 'Selected custom fields deleted.');
    }

    public function dataImport()
    {
        return view('pim.configuration.data-import');
    }

    /**
     * Handle PIM data import upload with validations per notes.
     */
    public function handleDataImport(Request $request)
    {
        $data = $request->validate([
            'import_file' => ['required', 'file', 'max:1024'], // 1MB
        ], [
            'import_file.required' => 'Please select a CSV file to import.',
            'import_file.file'     => 'File upload failed. Please try again.',
            'import_file.max'      => 'File size must be 1MB or less.',
        ]);

        /** @var \Illuminate\Http\UploadedFile $file */
        $file = $data['import_file'];

        // Allow ONLY .csv extension
        if (strtolower($file->getClientOriginalExtension()) !== 'csv') {
            return back()->withErrors([
                'import_file' => 'File type not allowed. Only CSV files are supported.',
            ])->withInput();
        }
        $rows = array_map('str_getcsv', file($file->getRealPath()));

        $header = array_map('trim', array_shift($rows));

        // Define expected column order / names for validation
        $expectedHeader = [
            'Employee Number',
            'First Name',
            'Last Name',
            'Gender',
            'Date of Birth',
        ];

        if ($header !== $expectedHeader) {
            return back()->withErrors([
                'import_file' => 'Column order or names do not match the expected format.',
            ]);
        }

        // Remove completely empty data rows (all cells blank)
        $cleanRows = [];
        foreach ($rows as $row) {
            $hasValue = false;
            foreach ($row as $cell) {
                if (trim((string) $cell) !== '') {
                    $hasValue = true;
                    break;
                }
            }
            if ($hasValue) {
                $cleanRows[] = $row;
            }
        }

        $rows = $cleanRows;
        $recordCount = count($rows);

        // If after cleaning there are no data rows at all, just show "No Records Imported"
        if ($recordCount === 0) {
            $summary = [
                'total'    => 0,
                'imported' => 0,
            ];

            return back()->with('import_summary', $summary);
        }

        // Maximum 100 records
        if ($recordCount > 100) {
            return back()->withErrors([
                'import_file' => 'Each import file must contain 100 records or less. Your file has ' . $recordCount . ' rows.',
            ]);
        }

        $errors = [];

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 accounting for header + 1-based index

            // Align row length with header length
            $row = array_pad($row, count($expectedHeader), null);

            [$employeeNumber, $firstName, $lastName, $gender, $dob] = $row;

            // First/Last name required
            if (!trim((string) $firstName) || !trim((string) $lastName)) {
                $errors[] = "Row {$rowNumber}: First Name and Last Name are required.";
            }

            // Gender must be Male/Female if present
            $genderTrimmed = trim((string) $gender);
            if ($genderTrimmed !== '' && !in_array(strtolower($genderTrimmed), ['male', 'female'], true)) {
                $errors[] = "Row {$rowNumber}: Gender must be Male or Female.";
            }

            // Date of Birth must be YYYY-MM-DD if present
            $dobTrimmed = trim((string) $dob);
            if ($dobTrimmed !== '') {
                $d = \DateTime::createFromFormat('Y-m-d', $dobTrimmed);
                $isValid = $d && $d->format('Y-m-d') === $dobTrimmed;
                if (!$isValid) {
                    $errors[] = "Row {$rowNumber}: Date of Birth must be in YYYY-MM-DD format.";
                }
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['import_file' => implode(' ', $errors)]);
        }

        // At this point, file is valid per notes. Actual DB import can be added later.
        // For now, just show an "Import Details" popup with total rows (or 0).
        $summary = [
            'total'    => $recordCount,
            'imported' => $recordCount, // placeholder until real import is wired
        ];

        return back()->with('import_summary', $summary);
    }

    /**
     * Download sample CSV file for data import.
     */
    public function downloadDataImportSample()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="pim-data-import-sample.csv"',
        ];

        $callback = function () {
            $output = fopen('php://output', 'w');
            // Header must match $expectedHeader used in handleDataImport
            fputcsv($output, ['Employee Number', 'First Name', 'Last Name', 'Gender', 'Date of Birth']);
            // Intentionally incorrect date formats so user sees:
            // "Row 2: Date of Birth must be in YYYY-MM-DD format. Row 3: Date of Birth must be in YYYY-MM-DD format."
            fputcsv($output, ['E001', 'John', 'Doe', 'Male', '1990-05-10']);
            fputcsv($output, ['E002', 'Jane', 'Smith', 'Female', '1992-11-25']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reportingMethods()
    {
        $enumMeta = $this->getFirstEnumColumnMeta('reporting_methods');

        $query = DB::table('reporting_methods')
            ->select('id', 'name', 'description')
            ->where('is_active', 1)
            ->orderBy('name');

        if ($enumMeta) {
            $query->addSelect($enumMeta['field']);
        }

        $reportingMethods = $query->get();

        return view('pim.configuration.reporting-methods', [
            'reportingMethods' => $reportingMethods,
            'reportingEnumMeta' => $enumMeta,
        ]);
    }

    /**
     * Store a new reporting method.
     */
    public function storeReportingMethod(Request $request)
    {
        $enumMeta = $this->getFirstEnumColumnMeta('reporting_methods');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ];

        if ($enumMeta) {
            $rules[$enumMeta['field']] = ['required', 'string', 'in:' . implode(',', $enumMeta['options'])];
        }

        $data = $request->validate($rules);

        $payload = [
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active'   => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ];

        if ($enumMeta && isset($data[$enumMeta['field']])) {
            $payload[$enumMeta['field']] = $data[$enumMeta['field']];
        }

        DB::table('reporting_methods')->insert($payload);

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Reporting method added.');
    }

    /**
     * Update an existing reporting method.
     */
    public function updateReportingMethod(Request $request, int $id)
    {
        $enumMeta = $this->getFirstEnumColumnMeta('reporting_methods');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ];

        if ($enumMeta) {
            $rules[$enumMeta['field']] = ['required', 'string', 'in:' . implode(',', $enumMeta['options'])];
        }

        $data = $request->validate($rules);

        $payload = [
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'updated_at'  => now(),
        ];

        if ($enumMeta && isset($data[$enumMeta['field']])) {
            $payload[$enumMeta['field']] = $data[$enumMeta['field']];
        }

        DB::table('reporting_methods')
            ->where('id', $id)
            ->update($payload);

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Reporting method updated.');
    }

    /**
     * Soft delete a reporting method (set is_active = 0).
     */
    public function deleteReportingMethod(int $id)
    {
        DB::table('reporting_methods')
            ->where('id', $id)
            ->update([
                'is_active'  => 0,
                'updated_at' => now(),
            ]);

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Reporting method deleted.');
    }

    /**
     * Bulk soft delete reporting methods.
     */
    public function bulkDeleteReportingMethods(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('reporting_methods')
                ->whereIn('id', $ids)
                ->update([
                    'is_active'  => 0,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Selected reporting methods deleted.');
    }

    public function terminationReasons()
    {
        $terminationReasons = DB::table('termination_reasons')
            ->select('id', 'name', 'description')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();
        return view('pim.configuration.termination-reasons', compact('terminationReasons'));
    }

    /**
     * Store a new termination reason.
     */
    public function storeTerminationReason(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('termination_reasons')->insert([
            'name'        => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active'   => 1,
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Termination reason added.');
    }

    /**
     * Update an existing termination reason.
     */
    public function updateTerminationReason(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('termination_reasons')
            ->where('id', $id)
            ->update([
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at'  => now(),
            ]);

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Termination reason updated.');
    }

    /**
     * Soft delete a termination reason (set is_active = 0).
     */
    public function deleteTerminationReason(int $id)
    {
        DB::table('termination_reasons')
            ->where('id', $id)
            ->update([
                'is_active'  => 0,
                'updated_at' => now(),
            ]);

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Termination reason deleted.');
    }

    /**
     * Bulk soft delete termination reasons.
     */
    public function bulkDeleteTerminationReasons(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('termination_reasons')
                ->whereIn('id', $ids)
                ->update([
                    'is_active'  => 0,
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Selected termination reasons deleted.');
    }
}

