<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PIMController extends Controller
{
    /**
     * Generate display name from first name, middle name, and last name
     */
    private function generateDisplayName(string $firstName, ?string $middleName, string $lastName): ?string
    {
        $displayName = trim(implode(' ', array_filter([
            $firstName,
            $middleName,
            $lastName,
        ])));
        
        return $displayName !== '' ? $displayName : null;
    }

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

    public function employeeList(Request $request)
    {
        // Get dropdown options
        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $employmentStatuses = DB::table('employment_statuses')->select('id', 'name')->orderBy('name')->get();

        // Build query with search filters
        $query = DB::table('employees')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employment_statuses', 'employees.employment_status_id', '=', 'employment_statuses.id')
            ->select(
                'employees.id',
                'employees.employee_number as employee_number',
                'employees.first_name',
                'employees.last_name',
                'employees.job_title_id',
                'employees.employment_status_id',
                'job_titles.name as job_title',
                'employment_statuses.name as employment_status'
            );

        // Apply search filters
        if ($request->filled('employee_name')) {
            $name = $request->input('employee_name');
            $query->where(function($q) use ($name) {
                $q->where('employees.first_name', 'like', "%{$name}%")
                  ->orWhere('employees.last_name', 'like', "%{$name}%");
            });
        }

        if ($request->filled('employee_id')) {
            $query->where('employees.employee_number', 'like', "%{$request->input('employee_id')}%");
        }

        if ($request->filled('employment_status')) {
            $query->where('employees.employment_status_id', $request->input('employment_status'));
        }

        if ($request->filled('job_title')) {
            $query->where('employees.job_title_id', $request->input('job_title'));
        }

        // Include filter
        $include = $request->input('include', 'current');
        if ($include === 'past') {
            $query->where('employees.status', 'terminated');
        } elseif ($include === 'current') {
            $query->where('employees.status', 'active');
        }
        // 'all' shows everything, no filter

        $employees = $query->orderBy('employees.employee_number')->get();

        return view('pim.employee-list', compact('employees', 'jobTitles', 'employmentStatuses'));
    }

    /**
     * Store a new employee.
     */
    public function storeEmployee(Request $request)
    {
        $data = $request->validate([
            'employee_number' => ['required', 'string', 'max:50', 'unique:employees,employee_number'],
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'job_title_id' => ['nullable', 'integer', 'exists:job_titles,id'],
            'employment_status_id' => ['nullable', 'integer', 'exists:employment_statuses,id'],
        ]);

        // Auto-generate display_name from first_name, middle_name, and last_name
        $displayName = $this->generateDisplayName($data['first_name'], $data['middle_name'] ?? null, $data['last_name']);

        $employeeId = DB::table('employees')->insertGetId([
            // For now, default all new employees into organization 1 (seeded org)
            // This can be wired to a real org selector later if needed.
            'organization_id' => 1,
            'employee_number' => $data['employee_number'],
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'display_name' => $displayName !== '' ? $displayName : null,
            'job_title_id' => $data['job_title_id'] ?? null,
            'employment_status_id' => $data['employment_status_id'] ?? null,
            'status' => 'active',
            'hire_date' => now()->toDateString(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        if ($request->hasFile('photo') && $employeeId) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                $path = $file->storeAs('employee_photos', $employeeId . '.' . $ext, 'public');

                $photoCol = $this->getEmployeePhotoColumn();
                if ($photoCol) {
                    DB::table('employees')->where('id', $employeeId)->update([
                        $photoCol => $path,
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->to(route('pim.employee-list') . '#employee-list-section')
            ->with('status', 'Employee added.');
    }

    /**
     * Update an existing employee.
     */
    public function updateEmployee(Request $request, int $id)
    {
        $data = $request->validate([
            'employee_number' => ['required', 'string', 'max:50', 'unique:employees,employee_number,' . $id],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'job_title_id' => ['nullable', 'integer', 'exists:job_titles,id'],
            'employment_status_id' => ['nullable', 'integer', 'exists:employment_statuses,id'],
        ]);

        DB::table('employees')
            ->where('id', $id)
            ->update([
                'employee_number' => $data['employee_number'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'job_title_id' => $data['job_title_id'] ?? null,
                'employment_status_id' => $data['employment_status_id'] ?? null,
                'updated_at' => now(),
            ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                $ext = strtolower($file->getClientOriginalExtension() ?: 'jpg');
                $path = $file->storeAs('employee_photos', $id . '.' . $ext, 'public');

                $photoCol = $this->getEmployeePhotoColumn();
                if ($photoCol) {
                    DB::table('employees')->where('id', $id)->update([
                        $photoCol => $path,
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return redirect()->to(route('pim.employee-list') . '#employee-list-section')
            ->with('status', 'Employee updated.');
    }

    /**
     * Delete an employee from the database.
     */
    public function deleteEmployee(int $id)
    {
        DB::table('employees')
            ->where('id', $id)
            ->delete();

        return redirect()->to(route('pim.employee-list') . '#employee-list-section')
            ->with('status', 'Employee deleted.');
    }

    /**
     * Bulk delete employees from the database.
     */
    public function bulkDeleteEmployees(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('employees')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->to(route('pim.employee-list') . '#employee-list-section')
            ->with('status', 'Selected employees deleted.');
    }

    public function addEmployee()
    {
        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $employmentStatuses = DB::table('employment_statuses')->select('id', 'name')->orderBy('name')->get();

        // Suggest next employee number based on existing ones (e.g. 0001 → 0002)
        $lastNumber = DB::table('employees')
            ->orderByRaw('CAST(employee_number AS UNSIGNED) DESC')
            ->value('employee_number');

        if ($lastNumber !== null && $lastNumber !== '') {
            $nextInt = (int) $lastNumber + 1;
            $padLength = strlen($lastNumber);
            $suggestedEmployeeNumber = str_pad((string) $nextInt, $padLength, '0', STR_PAD_LEFT);
        } else {
            $suggestedEmployeeNumber = '0001';
        }

        return view('pim.add-employee', [
            'mode' => 'create',
            'employee' => null,
            'photoUrl' => null,
            'jobTitles' => $jobTitles,
            'employmentStatuses' => $employmentStatuses,
            'suggestedEmployeeNumber' => $suggestedEmployeeNumber,
        ]);
    }

    private function getEmployeePhotoColumn(): ?string
    {
        foreach (['photo_path', 'profile_photo_path', 'photo', 'image_path', 'image'] as $col) {
            if (Schema::hasColumn('employees', $col)) {
                return $col;
            }
        }
        return null;
    }

    private function getEmployeePhotoUrlFromRow(object $employeeRow): ?string
    {
        $col = $this->getEmployeePhotoColumn();
        if ($col && !empty($employeeRow->{$col})) {
            return asset('storage/' . ltrim((string) $employeeRow->{$col}, '/'));
        }

        // Fallback: if we stored a file without DB column, try common paths
        $id = $employeeRow->id ?? null;
        if (!$id) return null;
        foreach (['jpg', 'jpeg', 'png', 'gif', 'webp'] as $ext) {
            $path = "employee_photos/{$id}.{$ext}";
            if (Storage::disk('public')->exists($path)) {
                return asset('storage/' . $path);
            }
        }
        return null;
    }

    public function editEmployee(int $id)
    {
        $employee = DB::table('employees')->where('id', $id)->first();
        if (!$employee) {
            return redirect()->route('pim.employee-list')->with('status', 'Employee not found.');
        }

        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $employmentStatuses = DB::table('employment_statuses')->select('id', 'name')->orderBy('name')->get();

        return view('pim.add-employee', [
            'mode' => 'edit',
            'employee' => $employee,
            'photoUrl' => $this->getEmployeePhotoUrlFromRow($employee),
            'jobTitles' => $jobTitles,
            'employmentStatuses' => $employmentStatuses,
            'suggestedEmployeeNumber' => null,
        ]);
    }

    public function reports(Request $request)
    {
        $query = DB::table('pim_reports')
            ->select('id', 'name', 'description', 'type')
            ->orderByDesc('id');

        // Apply search filter
        if ($request->filled('report_name')) {
            $reportName = $request->input('report_name');
            $query->where('name', 'like', "%{$reportName}%");
        }

        $reports = $query->get();

        return view('pim.reports', compact('reports'));
    }

    /**
     * Store a new pim_reports.
     */
    public function storeReport(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'in:education,skill,language,certification,other'],
        ]);

        DB::table('pim_reports')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'type' => $data['type'] ?? 'education',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('pim.reports')
            ->with('status', 'Report added.');
    }

    /**
     * Update an existing pim_reports.
     */
    public function updateReport(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'type' => ['nullable', 'string', 'in:education,skill,language,certification,other'],
        ]);

        DB::table('pim_reports')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'type' => $data['type'] ?? 'education',
                'updated_at' => now(),
            ]);

        return redirect()->route('pim.reports')
            ->with('status', 'Report updated.');
    }

    /**
     * Delete a pim_reports from the database.
     */
    public function deleteReport(int $id)
    {
        DB::table('pim_reports')
            ->where('id', $id)
            ->delete();

        return redirect()->route('pim.reports')
            ->with('status', 'Report deleted.');
    }

    /**
     * Bulk delete pim_reports from the database.
     */
    public function bulkDeleteReports(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('pim_reports')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('pim.reports')
            ->with('status', 'Selected reports deleted.');
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
            'ID',
            'First (& Middle) Name',
            'Last Name',
            'Job Title',
            'Employment Status',
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

        // Get lookup maps for job titles and employment statuses
        $jobTitleMap = DB::table('job_titles')
            ->pluck('id', 'name')
            ->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])
            ->toArray();

        $employmentStatusMap = DB::table('employment_statuses')
            ->pluck('id', 'name')
            ->mapWithKeys(fn($id, $name) => [strtolower(trim($name)) => $id])
            ->toArray();

        foreach ($rows as $index => $row) {
            $rowNumber = $index + 2; // +2 accounting for header + 1-based index

            // Align row length with header length
            $row = array_pad($row, count($expectedHeader), null);

            [$employeeId, $firstAndMiddleName, $lastName, $jobTitleName, $employmentStatusName] = $row;

            $employeeId = trim((string) $employeeId);
            $firstAndMiddleName = trim((string) $firstAndMiddleName);
            $lastName = trim((string) $lastName);
            $jobTitleName = trim((string) $jobTitleName);
            $employmentStatusName = trim((string) $employmentStatusName);

            // ID and Last Name required
            if ($employeeId === '' || $lastName === '') {
                $errors[] = "Row {$rowNumber}: ID and Last Name are required.";
            }

            // First (& Middle) Name required
            if ($firstAndMiddleName === '') {
                $errors[] = "Row {$rowNumber}: First (& Middle) Name is required.";
            }

            // Validate Job Title if provided
            if ($jobTitleName !== '' && !isset($jobTitleMap[strtolower($jobTitleName)])) {
                $errors[] = "Row {$rowNumber}: Job Title '{$jobTitleName}' not found.";
            }

            // Validate Employment Status if provided
            if ($employmentStatusName !== '' && !isset($employmentStatusMap[strtolower($employmentStatusName)])) {
                $errors[] = "Row {$rowNumber}: Employment Status '{$employmentStatusName}' not found.";
            }
        }

        if (!empty($errors)) {
            return back()->withErrors(['import_file' => implode(' ', $errors)]);
        }

        // Import valid rows into database
        $imported = 0;
        $skipped = 0;

        foreach ($rows as $index => $row) {
            $row = array_pad($row, count($expectedHeader), null);
            [$employeeId, $firstAndMiddleName, $lastName, $jobTitleName, $employmentStatusName] = $row;

            $employeeId = trim((string) $employeeId);
            $firstAndMiddleName = trim((string) $firstAndMiddleName);
            $lastName = trim((string) $lastName);
            $jobTitleName = trim((string) $jobTitleName);
            $employmentStatusName = trim((string) $employmentStatusName);

            // Skip if employee number already exists
            $exists = DB::table('employees')
                ->where('employee_number', $employeeId)
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            // Split First (& Middle) Name into first_name and middle_name
            $nameParts = preg_split('/\s+/', $firstAndMiddleName, 2);
            $firstName = $nameParts[0] ?? '';
            $middleName = isset($nameParts[1]) ? $nameParts[1] : null;

            // Auto-generate display_name from first_name, middle_name, and last_name
            $displayName = $this->generateDisplayName($firstName, $middleName, $lastName);

            // Look up Job Title ID
            $jobTitleId = null;
            if ($jobTitleName !== '') {
                $jobTitleId = $jobTitleMap[strtolower($jobTitleName)] ?? null;
            }

            // Look up Employment Status ID
            $employmentStatusId = null;
            if ($employmentStatusName !== '') {
                $employmentStatusId = $employmentStatusMap[strtolower($employmentStatusName)] ?? null;
            }

            // Prepare insert data
            $insertData = [
                'organization_id' => 1,
                'employee_number' => $employeeId,
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'display_name' => $displayName,
                'job_title_id' => $jobTitleId,
                'employment_status_id' => $employmentStatusId,
                'status' => 'active',
                'hire_date' => now()->toDateString(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert employee
            DB::table('employees')->insert($insertData);
            $imported++;
        }

        // Redirect to employee list with success message
        return redirect()->route('pim.employee-list')
            ->with('status', "Import completed. {$imported} record(s) imported" . ($skipped > 0 ? ", {$skipped} skipped (duplicate employee numbers)" : '') . '.');
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
            fputcsv($output, ['ID', 'First (& Middle) Name', 'Last Name', 'Job Title', 'Employment Status']);
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function reportingMethods()
    {
        $enumMeta = $this->getFirstEnumColumnMeta('reporting_methods');

        $query = DB::table('reporting_methods')
            ->select('id', 'name', 'description')
            // Show latest created methods at the top (like custom fields page)
            ->orderByDesc('id');

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
     * Delete a reporting method from the database.
     */
    public function deleteReportingMethod(int $id)
    {
        DB::table('reporting_methods')
            ->where('id', $id)
            ->delete();

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Reporting method deleted.');
    }

    /**
     * Bulk delete reporting methods from the database.
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
                ->delete();
        }

        return redirect()->route('pim.configuration.reporting-methods')
            ->with('status', 'Selected reporting methods deleted.');
    }

    public function terminationReasons()
    {
        $terminationReasons = DB::table('termination_reasons')
            ->select('id', 'name', 'description')
            // Show latest created reasons at the top (like custom fields page)
            ->orderByDesc('id')
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
     * Delete a termination reason from the database.
     */
    public function deleteTerminationReason(int $id)
    {
        DB::table('termination_reasons')
            ->where('id', $id)
            ->delete();

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Termination reason deleted.');
    }

    /**
     * Bulk delete termination reasons from the database.
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
                ->delete();
        }

        return redirect()->route('pim.configuration.termination-reasons')
            ->with('status', 'Selected termination reasons deleted.');
    }
}

