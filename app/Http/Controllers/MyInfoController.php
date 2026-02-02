<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class MyInfoController extends Controller
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
     * Resolve current authenticated user and their employee_id.
     */
    private function resolveUserAndEmployee(): array
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        if (!$userId) {
            abort(403);
        }

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user) {
            abort(403);
        }

        $employeeId = $user->employee_id ?? null;
        if (!$employeeId) {
            abort(404);
        }

        return [$userId, $employeeId];
    }

    public function index()
    {
        $authUser = session('auth_user');
        \Log::info('MyInfo index - Current auth_user: ' . json_encode($authUser));
        
        $userId = $authUser['id'] ?? null;

        // Get employee_id from users table
        $employeeId = null;
        $employee = null;
        $personalDetails = null;
        $user = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                // Fetch employee basic info
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();

                // Fetch personal details
                $personalDetails = DB::table('employee_personal_details')
                    ->where('employee_id', $employeeId)
                    ->first();
            }
        }

        // Fetch nationalities for dropdown
        $nationalities = DB::table('nationalities')
            ->orderBy('name')
            ->get();

        // Fetch attachments
        $query = DB::table('file_uploads')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                'file_uploads.description',
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->orderByDesc('file_uploads.uploaded_at');

        if ($userId) {
            $query->where('file_uploads.uploaded_by', $userId);
        }

        $attachments = $query->limit(50)->get()->map(function ($row) {
            // Human readable size
            $row->size = $row->size_bytes >= 1024
                ? number_format($row->size_bytes / 1024, 2) . ' kB'
                : $row->size_bytes . ' B';

            // Split date and time for nicer display (localised to Asia/Kolkata)
            if ($row->uploaded_at) {
                $dt = Carbon::parse($row->uploaded_at)->timezone('Asia/Kolkata');
                $row->date_only = $dt->format('Y-m-d');
                $row->time_only = $dt->format('h:i A');
            } else {
                $row->date_only = null;
                $row->time_only = null;
            }

            return $row;
        });

        return view('myinfo.myinfo', compact(
            'attachments',
            'employee',
            'personalDetails',
            'nationalities',
            'user'
        ));
    }

    /**
     * Update personal details (employee + employee_personal_details + username).
     */
    public function updatePersonalDetails(Request $request)
    {
        \Log::info('updatePersonalDetails called with data: ' . json_encode($request->all()));
        
        [$userId, $employeeId] = $this->resolveUserAndEmployee();
        
        \Log::info('Resolved userId: ' . $userId . ', employeeId: ' . $employeeId);

        $data = $request->validate([
            'username'        => ['required', 'string', 'max:255', 'unique:users,username,' . $userId],
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'employee_number' => ['nullable', 'string', 'max:50'],
            'other_id' => ['nullable', 'string', 'max:100'],
            'drivers_license' => ['nullable', 'string', 'max:100'],
            'license_expiry'  => ['nullable', 'date'],
            'nationality_id'  => ['nullable', 'integer'],
            'marital_status'  => ['nullable', 'string', 'max:50'],
            'date_of_birth'   => ['nullable', 'date'],
            'gender'          => ['nullable', 'in:male,female,other'],
        ]);
        
        \Log::info('Validated data: ' . json_encode($data));

        // Update username in users table
        DB::table('users')
            ->where('id', $userId)
            ->update([
                'username' => $data['username'],
            ]);

        // Update session if username changed
        $authUser = session('auth_user');
        \Log::info('Before session update - Current auth_user: ' . json_encode($authUser));
        \Log::info('New username from form: ' . $data['username']);
        
        if ($authUser && $authUser['username'] !== $data['username']) {
            \Log::info('Username changed, updating session');
            
            // Update session directly
            session(['auth_user.username' => $data['username']]);
            session(['auth_user.name' => $data['username']]);
            
            \Log::info('After session update - New auth_user: ' . json_encode(session('auth_user')));
        } else {
            \Log::info('Username not changed or auth_user not found');
        }

        // Build a friendly display name from parts
        $displayName = $this->generateDisplayName($data['first_name'], $data['middle_name'] ?? null, $data['last_name']);

        // Update employees table
        DB::table('employees')
            ->where('id', $employeeId)
            ->update([
                'first_name' => $data['first_name'],
                'middle_name' => $data['middle_name'] ?? null,
                'last_name' => $data['last_name'],
                'display_name' => $displayName !== '' ? $displayName : null,
                'employee_number' => $data['employee_number'] ?? null,
                'marital_status' => $data['marital_status'] ?? null,
                'gender' => $data['gender'] ?? null,
                'date_of_birth' => $data['date_of_birth'] ?? null,
            ]);

        // Upsert into employee_personal_details
        $personal = DB::table('employee_personal_details')
            ->where('employee_id', $employeeId)
            ->first();

        $personalPayload = [
            'other_id' => $data['other_id'] ?? null,
            'drivers_license' => $data['drivers_license'] ?? null,
            'license_expiry' => $data['license_expiry'] ?? null,
            'nationality_id' => $data['nationality_id'] ?? null,
        ];

        if ($personal) {
            DB::table('employee_personal_details')
                ->where('employee_id', $employeeId)
                ->update($personalPayload);
        } else {
            DB::table('employee_personal_details')
                ->insert(array_merge($personalPayload, [
                    'employee_id' => $employeeId,
                ]));
        }

        return redirect()->route('myinfo')
            ->with([
                'status' => 'Personal details updated.',
                'scroll_section' => 'personal-details-section',
            ]);
    }

    /**
     * Update custom fields (currently Blood Type).
     */
    public function updateCustomFields(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'blood_group' => ['nullable', 'string', 'max:3'],
        ]);

        $personal = DB::table('employee_personal_details')
            ->where('employee_id', $employeeId)
            ->first();

        if ($personal) {
            DB::table('employee_personal_details')
                ->where('employee_id', $employeeId)
                ->update(['blood_group' => $data['blood_group'] ?? null]);
        } else {
            DB::table('employee_personal_details')
                ->insert([
                    'employee_id' => $employeeId,
                    'blood_group' => $data['blood_group'] ?? null,
                ]);
        }

        return redirect()->route('myinfo')
            ->with([
                'status' => 'Custom fields updated.',
                'scroll_section' => 'custom-fields-section',
            ]);
    }

    /**
     * Store a new attachment for current user.
     */
    public function storeAttachment(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'attachment' => ['required', 'file', 'max:5120'], // 5MB
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $data['attachment'];

        $storedName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('private/myinfo', $storedName);

        $id = DB::table('file_uploads')->insertGetId([
            'stored_name' => $storedName,
            'original_name' => $file->getClientOriginalName(),
            'description' => $data['description'] ?? null,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize(),
            'path' => $path,
            'uploaded_by' => $userId,
            'uploaded_at' => now(),
        ]);

        return redirect()->route('myinfo')
            ->with([
                'status' => 'Attachment uploaded.',
                'scroll_to_attachment' => $id,
            ]);
    }

    /**
     * Update an attachment (description and optionally file).
     */
    public function updateAttachment(Request $request, int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'description' => ['nullable', 'string', 'max:255'],
            'attachment' => ['nullable', 'file', 'max:5120'],
        ]);

        $query = DB::table('file_uploads')
            ->where('id', $id)
            ->where('uploaded_by', $userId);

        $attachment = $query->first();

        if (!$attachment) {
            return redirect()->route('myinfo');
        }

        $updatePayload = [
            'description' => $data['description'] ?? null,
        ];

        if (!empty($data['attachment'])) {
            $file = $data['attachment'];

            // Remove old file if exists
            if (!empty($attachment->path) && Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }

            $storedName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('private/myinfo', $storedName);

            $updatePayload = array_merge($updatePayload, [
                'stored_name' => $storedName,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => $file->getClientMimeType(),
                'size_bytes' => $file->getSize(),
                'path' => $path,
                'uploaded_at' => now(),
            ]);
        }

        $query->update($updatePayload);

        return redirect()->route('myinfo')
            ->with([
                'status' => 'Attachment updated.',
                'scroll_to_attachment' => $id,
            ]);
    }

    /**
     * Delete an attachment and its stored file.
     */
    public function deleteAttachment(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $attachment = DB::table('file_uploads')
            ->where('id', $id)
            ->where('uploaded_by', $userId)
            ->first();

        if ($attachment) {
            if (!empty($attachment->path) && Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }

            DB::table('file_uploads')
                ->where('id', $id)
                ->delete();
        }

        return redirect()->route('myinfo')
            ->with('status', 'Attachment deleted.');
    }

    /**
     * Download an attachment file.
     */
    public function downloadAttachment(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $attachment = DB::table('file_uploads')
            ->where('id', $id)
            ->where('uploaded_by', $userId)
            ->first();

        if (!$attachment || empty($attachment->path) || !Storage::exists($attachment->path)) {
            abort(404);
        }

        $downloadName = $attachment->original_name ?? basename($attachment->path);

        return Storage::download($attachment->path, $downloadName);
    }

    public function contactDetails()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;
        $contactDetails = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();

                $contactDetails = DB::table('employee_personal_details')
                    ->where('employee_id', $employeeId)
                    ->first();
            }
        }

        // Ensure view always receives an object (avoids "Trying to get property of null")
        $contactDetails = $contactDetails ?? (object) array_fill_keys([
            'address1',
            'address2',
            'city',
            'state',
            'postal_code',
            'country',
            'home_phone',
            'mobile_phone',
            'work_phone',
            'work_email',
            'other_email',
        ], '');

        // Fetch attachments
        $query = DB::table('file_uploads')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                DB::raw("'' as description"),
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->orderByDesc('file_uploads.uploaded_at');

        if ($userId) {
            $query->where('file_uploads.uploaded_by', $userId);
        }

        $attachments = $query->limit(50)->get()->map(function ($row) {
            $row->size = $row->size_bytes >= 1024
                ? number_format($row->size_bytes / 1024, 2) . ' kB'
                : $row->size_bytes . ' B';
            $row->date_added = $row->uploaded_at ? Carbon::parse($row->uploaded_at)->format('Y-m-d') : null;
            return $row;
        });

        return view('myinfo.contact-details', compact('employee', 'contactDetails', 'attachments'));
    }

    /**
     * Update contact details (address, telephone, email in employee_personal_details).
     */
    public function updateContactDetails(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'address1' => ['nullable', 'string', 'max:191'],
            'address2' => ['nullable', 'string', 'max:191'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'home_phone' => ['nullable', 'string', 'max:50'],
            'mobile_phone' => ['nullable', 'string', 'max:50'],
            'work_phone' => ['nullable', 'string', 'max:50'],
            'work_email' => ['nullable', 'email', 'max:191'],
            'other_email' => ['nullable', 'email', 'max:191'],
        ]);

        $personal = DB::table('employee_personal_details')
            ->where('employee_id', $employeeId)
            ->first();

        $payload = [
            'address1' => $data['address1'] ?? null,
            'address2' => $data['address2'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'country' => $data['country'] ?? null,
            'home_phone' => $data['home_phone'] ?? null,
            'mobile_phone' => $data['mobile_phone'] ?? null,
            'work_phone' => $data['work_phone'] ?? null,
            'work_email' => $data['work_email'] ?? null,
            'other_email' => $data['other_email'] ?? null,
        ];

        if ($personal) {
            DB::table('employee_personal_details')
                ->where('employee_id', $employeeId)
                ->update($payload);
        } else {
            DB::table('employee_personal_details')
                ->insert(array_merge($payload, ['employee_id' => $employeeId]));
        }

        return redirect()->route('myinfo.contact-details')
            ->with('status', 'Contact details updated.');
    }

    public function emergencyContacts()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        $emergencyContacts = collect();
        if ($employeeId) {
            $emergencyContacts = DB::table('employee_emergency_contacts')
                ->where('employee_id', $employeeId)
                ->orderBy('id')
                ->get();
        }

        // Fetch attachments
        $query = DB::table('file_uploads')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                DB::raw("'' as description"),
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->orderByDesc('file_uploads.uploaded_at');

        if ($userId) {
            $query->where('file_uploads.uploaded_by', $userId);
        }

        $attachments = $query->limit(50)->get()->map(function ($row) {
            $row->size = $row->size_bytes >= 1024
                ? number_format($row->size_bytes / 1024, 2) . ' kB'
                : $row->size_bytes . ' B';
            $row->date_added = $row->uploaded_at ? Carbon::parse($row->uploaded_at)->format('Y-m-d') : null;
            return $row;
        });

        return view('myinfo.emergency-contacts', compact('employee', 'emergencyContacts', 'attachments'));
    }

    /**
     * Store a new emergency contact (family/close contact) for the current employee.
     */
    public function storeEmergencyContact(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relationship' => ['required', 'string', 'max:100'],
            'mobile_phone' => ['required', 'string', 'digits:10'],
            'email' => ['nullable', 'string', 'max:191', 'regex:/^[^@]+@[^@]+\.[^@]+$/'],
        ], [
            'mobile_phone.digits' => 'Emergency Contacter No. must be exactly 10 digits.',
            'email.regex' => 'Email must contain @ and a dot (e.g. name@domain.com).',
        ]);

        $isPrimary = DB::table('employee_emergency_contacts')
            ->where('employee_id', $employeeId)
            ->count() === 0 ? 1 : 0;

        $now = now();
        DB::table('employee_emergency_contacts')->insert([
            'employee_id' => $employeeId,
            'name' => $data['name'],
            'relationship' => $data['relationship'],
            'home_phone' => null,
            'mobile_phone' => $data['mobile_phone'],
            'work_phone' => null,
            'email' => $data['email'] ?? null,
            'is_primary' => $isPrimary,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        return redirect()->route('myinfo.emergency-contacts')
            ->with('status', 'Successfully updated.');
    }

    /**
     * Update an existing emergency contact (must belong to current employee).
     */
    public function updateEmergencyContact(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $contact = DB::table('employee_emergency_contacts')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();
        if (!$contact) {
            abort(404);
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'relationship' => ['required', 'string', 'max:100'],
            'mobile_phone' => ['required', 'string', 'digits:10'],
            'email' => ['nullable', 'string', 'max:191', 'regex:/^[^@]+@[^@]+\.[^@]+$/'],
        ], [
            'mobile_phone.digits' => 'Emergency Contacter No. must be exactly 10 digits.',
            'email.regex' => 'Email must contain @ and a dot (e.g. name@domain.com).',
        ]);

        DB::table('employee_emergency_contacts')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'name' => $data['name'],
                'relationship' => $data['relationship'],
                'mobile_phone' => $data['mobile_phone'],
                'email' => $data['email'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.emergency-contacts')
            ->with('status', 'Successfully updated.');
    }

    /**
     * Delete an emergency contact (must belong to current employee).
     */
    public function deleteEmergencyContact($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_emergency_contacts')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();
        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.emergency-contacts')
            ->with('status', 'Contact deleted.');
    }

    public function dependents()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        // Fetch dependents (use employee_dependents if table exists, else empty)
        $dependents = collect([]);
        try {
            if (Schema::hasTable('employee_dependents') && $employeeId) {
                $dependents = DB::table('employee_dependents')
                    ->where('employee_id', $employeeId)
                    ->orderBy('id')
                    ->get()
                    ->map(function ($row) {
                        $row->date_of_birth = $row->date_of_birth ?? '';
                        return $row;
                    });
            }
        } catch (\Throwable $e) {
            // Table may not exist
        }

        // Fetch attachments (same as index)
        $query = DB::table('file_uploads')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                DB::raw("'' as description"),
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->orderByDesc('file_uploads.uploaded_at');
        if ($userId) {
            $query->where('file_uploads.uploaded_by', $userId);
        }
        $attachments = $query->limit(50)->get()->map(function ($row) {
            $row->size = $row->size_bytes >= 1024
                ? number_format($row->size_bytes / 1024, 2) . ' kB'
                : $row->size_bytes . ' B';
            $row->date_added = $row->uploaded_at ? Carbon::parse($row->uploaded_at)->format('Y-m-d') : null;
            return $row;
        });

        return view('myinfo.dependents', compact('employee', 'dependents', 'attachments'));
    }

    public function immigration()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        return view('myinfo.immigration', compact('employee'));
    }

    public function job()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        return view('myinfo.job', compact('employee'));
    }

    public function salary()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        return view('myinfo.salary', compact('employee'));
    }

    public function reportTo()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        return view('myinfo.report-to', compact('employee'));
    }

    public function qualifications()
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $employee = DB::table('employees')
            ->where('id', $employeeId)
            ->first();

        // Fetch work experience
        $workExperience = DB::table('employee_work_experience')
            ->where('employee_id', $employeeId)
            ->orderBy('id')
            ->get();

        // Fetch education
        $education = DB::table('employee_education')
            ->where('employee_id', $employeeId)
            ->orderBy('id')
            ->get();

        // Fetch skills
        $skills = DB::table('employee_skills')
            ->where('employee_id', $employeeId)
            ->orderBy('id')
            ->get();

        // Fetch languages
        $languages = DB::table('employee_languages')
            ->where('employee_id', $employeeId)
            ->orderBy('id')
            ->get();

        // Fetch licenses
        $licenses = DB::table('employee_licenses')
            ->where('employee_id', $employeeId)
            ->orderBy('id')
            ->get();

        // Fetch qualification attachments
        $attachments = DB::table('employee_qualification_attachments')
            ->leftJoin('file_uploads', 'employee_qualification_attachments.file_upload_id', '=', 'file_uploads.id')
            ->leftJoin('users', 'file_uploads.uploaded_by', '=', 'users.id')
            ->select(
                'file_uploads.id',
                'file_uploads.original_name as file_name',
                'employee_qualification_attachments.comment',
                'file_uploads.mime_type as type',
                'file_uploads.size_bytes',
                'file_uploads.uploaded_at',
                DB::raw("COALESCE(users.username, 'System') as added_by")
            )
            ->where('employee_qualification_attachments.employee_id', $employeeId)
            ->orderByDesc('file_uploads.uploaded_at')
            ->get()
            ->map(function ($row) {
                $row->size = $row->size_bytes >= 1024
                    ? number_format($row->size_bytes / 1024, 2) . ' kB'
                    : $row->size_bytes . ' B';
                $row->date_added = $row->uploaded_at ? Carbon::parse($row->uploaded_at)->format('Y-m-d') : null;
                return $row;
            });

        return view('myinfo.qualifications', compact(
            'employee',
            'workExperience',
            'education',
            'skills',
            'languages',
            'licenses',
            'attachments'
        ));
    }

    public function memberships()
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        $employeeId = null;
        $employee = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;

            if ($employeeId) {
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
            }
        }

        return view('myinfo.memberships', compact('employee'));
    }

    // Work Experience CRUD
    public function storeWorkExperience(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'company' => ['required', 'string', 'max:191'],
            'job_title' => ['required', 'string', 'max:191'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_work_experience')->insert([
            'employee_id' => $employeeId,
            'company' => $data['company'],
            'job_title' => $data['job_title'],
            'from_date' => $data['from'],
            'to_date' => $data['to'],
            'comment' => $data['comment'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Work experience added successfully.');
    }

    public function updateWorkExperience(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $workExp = DB::table('employee_work_experience')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$workExp) {
            abort(404);
        }

        $data = $request->validate([
            'company' => ['required', 'string', 'max:191'],
            'job_title' => ['required', 'string', 'max:191'],
            'from' => ['nullable', 'date'],
            'to' => ['nullable', 'date', 'after_or_equal:from'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_work_experience')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'company' => $data['company'],
                'job_title' => $data['job_title'],
                'from_date' => $data['from'],
                'to_date' => $data['to'],
                'comment' => $data['comment'],
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Work experience updated successfully.');
    }

    public function deleteWorkExperience($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_work_experience')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Work experience deleted.');
    }

    // Education CRUD
    public function storeEducation(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'level' => ['required', 'string', 'max:100'],
            'institute' => ['nullable', 'string', 'max:191'],
            'major_specialization' => ['nullable', 'string', 'max:191'],
            'year' => ['nullable', 'string', 'max:20'],
            'gpa_score' => ['nullable', 'string', 'max:50'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        DB::table('employee_education')->insert([
            'employee_id' => $employeeId,
            'level' => $data['level'],
            'institute' => $data['institute'],
            'major_specialization' => $data['major_specialization'],
            'year' => $data['year'],
            'gpa_score' => $data['gpa_score'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Education added successfully.');
    }

    public function updateEducation(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $education = DB::table('employee_education')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$education) {
            abort(404);
        }

        $data = $request->validate([
            'level' => ['required', 'string', 'max:100'],
            'institute' => ['nullable', 'string', 'max:191'],
            'major_specialization' => ['nullable', 'string', 'max:191'],
            'year' => ['nullable', 'string', 'max:20'],
            'gpa_score' => ['nullable', 'string', 'max:50'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        DB::table('employee_education')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'level' => $data['level'],
                'institute' => $data['institute'],
                'major_specialization' => $data['major_specialization'],
                'year' => $data['year'],
                'gpa_score' => $data['gpa_score'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Education updated successfully.');
    }

    public function deleteEducation($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_education')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Education deleted.');
    }

    // Skills CRUD
    public function storeSkill(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'skill' => ['required', 'string', 'max:191'],
            'years_of_experience' => ['nullable', 'string', 'max:50'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_skills')->insert([
            'employee_id' => $employeeId,
            'skill' => $data['skill'],
            'years_of_experience' => $data['years_of_experience'],
            'comments' => $data['comments'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Skill added successfully.');
    }

    public function updateSkill(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $skill = DB::table('employee_skills')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$skill) {
            abort(404);
        }

        $data = $request->validate([
            'skill' => ['required', 'string', 'max:191'],
            'years_of_experience' => ['nullable', 'string', 'max:50'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_skills')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'skill' => $data['skill'],
                'years_of_experience' => $data['years_of_experience'],
                'comments' => $data['comments'],
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Skill updated successfully.');
    }

    public function deleteSkill($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_skills')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Skill deleted.');
    }

    // Languages CRUD
    public function storeLanguage(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'language' => ['required', 'string', 'max:100'],
            'fluency' => ['required', 'string', 'max:100'],
            'competency' => ['required', 'string', 'max:100'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_languages')->insert([
            'employee_id' => $employeeId,
            'language' => $data['language'],
            'fluency' => $data['fluency'],
            'competency' => $data['competency'],
            'comments' => $data['comments'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Language added successfully.');
    }

    public function updateLanguage(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $language = DB::table('employee_languages')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$language) {
            abort(404);
        }

        $data = $request->validate([
            'language' => ['required', 'string', 'max:100'],
            'fluency' => ['required', 'string', 'max:100'],
            'competency' => ['required', 'string', 'max:100'],
            'comments' => ['nullable', 'string', 'max:1000'],
        ]);

        DB::table('employee_languages')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'language' => $data['language'],
                'fluency' => $data['fluency'],
                'competency' => $data['competency'],
                'comments' => $data['comments'],
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Language updated successfully.');
    }

    public function deleteLanguage($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_languages')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Language deleted.');
    }

    // Licenses CRUD
    public function storeLicense(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'license_type' => ['required', 'string', 'max:191'],
            'license_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issued_date'],
        ]);

        DB::table('employee_licenses')->insert([
            'employee_id' => $employeeId,
            'license_type' => $data['license_type'],
            'license_number' => $data['license_number'],
            'issued_date' => $data['issued_date'],
            'expiry_date' => $data['expiry_date'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'License added successfully.');
    }

    public function updateLicense(Request $request, $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $license = DB::table('employee_licenses')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$license) {
            abort(404);
        }

        $data = $request->validate([
            'license_type' => ['required', 'string', 'max:191'],
            'license_number' => ['nullable', 'string', 'max:100'],
            'issued_date' => ['nullable', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issued_date'],
        ]);

        DB::table('employee_licenses')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->update([
                'license_type' => $data['license_type'],
                'license_number' => $data['license_number'],
                'issued_date' => $data['issued_date'],
                'expiry_date' => $data['expiry_date'],
                'updated_at' => now(),
            ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'License updated successfully.');
    }

    public function deleteLicense($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $deleted = DB::table('employee_licenses')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        if (!$deleted) {
            abort(404);
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'License deleted.');
    }

    // Qualification Attachments CRUD
    public function storeQualificationAttachment(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'attachment' => ['required', 'file', 'max:5120'], // 5MB
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $data['attachment'];
        $storedName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('private/qualifications', $storedName);

        $fileId = DB::table('file_uploads')->insertGetId([
            'stored_name' => $storedName,
            'original_name' => $file->getClientOriginalName(),
            'description' => $data['comment'] ?? null,
            'mime_type' => $file->getClientMimeType(),
            'size_bytes' => $file->getSize(),
            'path' => $path,
            'uploaded_by' => $userId,
            'uploaded_at' => now(),
        ]);

        DB::table('employee_qualification_attachments')->insert([
            'employee_id' => $employeeId,
            'file_upload_id' => $fileId,
            'comment' => $data['comment'] ?? null,
            'created_at' => now(),
        ]);

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Attachment uploaded successfully.');
    }

    public function deleteQualificationAttachment($id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $attachment = DB::table('employee_qualification_attachments')
            ->leftJoin('file_uploads', 'employee_qualification_attachments.file_upload_id', '=', 'file_uploads.id')
            ->where('employee_qualification_attachments.file_upload_id', $id)
            ->where('employee_qualification_attachments.employee_id', $employeeId)
            ->first();

        if ($attachment) {
            // Delete file from storage
            if (!empty($attachment->path) && Storage::exists($attachment->path)) {
                Storage::delete($attachment->path);
            }

            // Delete from file_uploads table
            DB::table('file_uploads')
                ->where('id', $id)
                ->delete();

            // Delete from qualification attachments table
            DB::table('employee_qualification_attachments')
                ->where('file_upload_id', $id)
                ->delete();
        }

        return redirect()->route('myinfo.qualifications')
            ->with('status', 'Attachment deleted.');
    }
}

