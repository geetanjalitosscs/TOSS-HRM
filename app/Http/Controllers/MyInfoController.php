<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class MyInfoController extends Controller
{
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
        $userId = $authUser['id'] ?? null;
        
        // Get employee_id from users table
        $employeeId = null;
        $employee = null;
        $personalDetails = null;
        
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
            'nationalities'
        ));
    }

    /**
     * Update personal details (employee + employee_personal_details).
     */
    public function updatePersonalDetails(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['nullable', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'employee_number' => ['nullable', 'string', 'max:50'],
            'other_id'        => ['nullable', 'string', 'max:100'],
            'drivers_license' => ['nullable', 'string', 'max:100'],
            'license_expiry'  => ['nullable', 'date'],
            'nationality_id'  => ['nullable', 'integer'],
            'marital_status'  => ['nullable', 'string', 'max:50'],
            'date_of_birth'   => ['nullable', 'date'],
            'gender'          => ['nullable', 'in:male,female,other'],
        ]);

        // Build a friendly display name from parts
        $displayName = trim(implode(' ', array_filter([
            $data['first_name'] ?? null,
            $data['middle_name'] ?? null,
            $data['last_name'] ?? null,
        ])));

        // Update employees table
        DB::table('employees')
            ->where('id', $employeeId)
            ->update([
                'first_name'      => $data['first_name'],
                'middle_name'     => $data['middle_name'] ?? null,
                'last_name'       => $data['last_name'],
                'display_name'    => $displayName !== '' ? $displayName : null,
                'employee_number' => $data['employee_number'] ?? null,
                'marital_status'  => $data['marital_status'] ?? null,
                'gender'          => $data['gender'] ?? null,
                'date_of_birth'   => $data['date_of_birth'] ?? null,
            ]);

        // Upsert into employee_personal_details
        $personal = DB::table('employee_personal_details')
            ->where('employee_id', $employeeId)
            ->first();

        $personalPayload = [
            'other_id'       => $data['other_id'] ?? null,
            'drivers_license'=> $data['drivers_license'] ?? null,
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
            'attachment'  => ['required', 'file', 'max:5120'], // 5MB
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $file = $data['attachment'];

        $storedName = Str::uuid()->toString() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('private/myinfo', $storedName);

        $id = DB::table('file_uploads')->insertGetId([
            'stored_name'   => $storedName,
            'original_name' => $file->getClientOriginalName(),
            'description'   => $data['description'] ?? null,
            'mime_type'     => $file->getClientMimeType(),
            'size_bytes'    => $file->getSize(),
            'path'          => $path,
            'uploaded_by'   => $userId,
            'uploaded_at'   => now(),
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
            'attachment'  => ['nullable', 'file', 'max:5120'],
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
                'stored_name'   => $storedName,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getClientMimeType(),
                'size_bytes'    => $file->getSize(),
                'path'          => $path,
                'uploaded_at'   => now(),
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
}

