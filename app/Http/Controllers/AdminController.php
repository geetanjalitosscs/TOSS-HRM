<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $authUser = session('auth_user');
        $currentUserId = $authUser['id'] ?? null;

        // Get current user's is_main_user status
        $currentUser = null;
        if ($currentUserId) {
            $currentUser = DB::table('users')
                ->where('id', $currentUserId)
                ->select('id', 'is_main_user')
                ->first();
        }

        $username = $request->input('username');
        $userRole = $request->input('user_role');
        $employeeName = $request->input('employee_name');
        $status = $request->input('status');

        $query = DB::table('users')
            ->leftJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->leftJoin('employees', function($join) {
                $join->on('users.employee_id', '=', 'employees.id')
                     ->whereNull('employees.deleted_at');
            })
            ->whereNull('users.deleted_at')
            ->select(
                'users.id',
                'users.username',
                'users.email',
                'users.employee_id',
                'users.is_active',
                'users.is_main_user',
                'users.created_by',
                DB::raw("COALESCE(roles.id, 0) as role_id"),
                DB::raw("COALESCE(roles.name, 'HR') as role"),
                DB::raw("COALESCE(employees.display_name, CONCAT(COALESCE(employees.first_name, ''), ' ', COALESCE(employees.last_name, '')), '') as employee_name")
            );

        // Filter based on is_main_user: if not main user, show only own record
        if ($currentUser && isset($currentUser->is_main_user) && $currentUser->is_main_user != 1) {
            $query->where('users.id', $currentUserId);
        }

        if ($username) {
            $query->where('users.username', 'like', '%' . $username . '%');
        }

        if ($userRole) {
            $query->where('roles.id', $userRole);
        }

        if ($employeeName) {
            $query->where(function($q) use ($employeeName) {
                $q->where('employees.first_name', 'like', '%' . $employeeName . '%')
                  ->orWhere('employees.last_name', 'like', '%' . $employeeName . '%')
                  ->orWhere('employees.display_name', 'like', '%' . $employeeName . '%');
            });
        }

        if ($status !== null && $status !== '') {
            $query->where('users.is_active', $status === 'Enabled' ? 1 : 0);
        }

        $users = $query->get()->map(function($user) {
            $user->status = $user->is_active == 1 ? 'Enabled' : 'Disabled';
            return $user;
        });

        $roles = DB::table('roles')->select('id', 'name')->orderBy('name')->get();
        $employees = DB::table('employees')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as name"))
            ->orderBy('name')
            ->get();

        return view('admin.admin', compact('users', 'roles', 'employees'));
    }

    public function storeUser(Request $request)
    {
        $authUser = session('auth_user');
        $currentUserId = $authUser['id'] ?? null;

        $data = $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:users,username'],
            'email' => ['required', 'email', 'max:191', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'employee_id' => ['nullable', 'integer', 'exists:employees,id'],
            'is_active' => ['nullable', 'boolean'],
            'is_main_user' => ['nullable', 'boolean'],
        ]);

        $userId = DB::table('users')->insertGetId([
            'username' => $data['username'],
            'email' => $data['email'],
            'password_hash' => Hash::make($data['password']),
            'employee_id' => !empty($data['employee_id']) ? (int)$data['employee_id'] : null,
            'is_active' => isset($data['is_active']) && $data['is_active'] == '1' ? 1 : 0,
            'is_main_user' => isset($data['is_main_user']) && $data['is_main_user'] == '1' ? 1 : 0,
            'created_by' => $currentUserId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign role
        DB::table('user_roles')->insert([
            'user_id' => $userId,
            'role_id' => $data['role_id'],
            'created_at' => now(),
        ]);

        return redirect()->route('admin')
            ->with('status', 'User created successfully.');
    }

    public function updateUser(Request $request, int $id)
    {
        // Check if user is main user
        $user = DB::table('users')->where('id', $id)->first();
        $isMainUser = $user && isset($user->is_main_user) && $user->is_main_user == 1;

        $data = $request->validate([
            'username' => ['required', 'string', 'max:100', 'unique:users,username,' . $id],
            'email' => ['required', 'email', 'max:191', 'unique:users,email,' . $id],
            'password' => ['nullable', 'string', 'min:6'],
            'role_id' => ['required', 'integer', 'exists:roles,id'],
            'employee_id' => ['nullable', 'integer', 'exists:employees,id'],
            'is_active' => ['nullable', 'boolean'],
            'is_main_user' => ['nullable', 'boolean'],
        ]);

        $updateData = [
            'username' => $data['username'],
            'email' => $data['email'],
            'employee_id' => !empty($data['employee_id']) ? (int)$data['employee_id'] : null,
            'updated_at' => now(),
        ];

        // If main user, preserve original is_active and is_main_user values
        if ($isMainUser) {
            $updateData['is_active'] = $user->is_active ?? 1;
            $updateData['is_main_user'] = 1;
        } else {
            $updateData['is_active'] = isset($data['is_active']) && $data['is_active'] == '1' ? 1 : 0;
            $updateData['is_main_user'] = isset($data['is_main_user']) && $data['is_main_user'] == '1' ? 1 : 0;
        }

        if (!empty($data['password'])) {
            $updateData['password_hash'] = Hash::make($data['password']);
        }

        DB::table('users')
            ->where('id', $id)
            ->update($updateData);

        // Update role
        DB::table('user_roles')
            ->where('user_id', $id)
            ->delete();

        DB::table('user_roles')->insert([
            'user_id' => $id,
            'role_id' => $data['role_id'],
            'created_at' => now(),
        ]);

        return redirect()->route('admin')
            ->with('status', 'User updated successfully.');
    }

    public function deleteUser(int $id)
    {
        // Check if user is main user
        $user = DB::table('users')->where('id', $id)->first();
        if ($user && isset($user->is_main_user) && $user->is_main_user == 1) {
            return redirect()->route('admin')
                ->with('error', 'Cannot delete main user. This user account is protected and required for system administration.');
        }

        DB::table('users')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return redirect()->route('admin')
            ->with('status', 'User deleted successfully.');
    }

    public function bulkDeleteUsers(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('admin')
                ->with('status', 'No users selected.');
        }

        // Filter out main users
        $mainUserIds = DB::table('users')
            ->whereIn('id', $ids)
            ->where('is_main_user', 1)
            ->pluck('id')
            ->toArray();

        $ids = array_diff($ids, $mainUserIds);

        if (empty($ids)) {
            return redirect()->route('admin')
                ->with('error', 'Cannot delete main users. These user accounts are protected and required for system administration.');
        }

        DB::table('users')
            ->whereIn('id', $ids)
            ->update(['deleted_at' => now()]);

        return redirect()->route('admin')
            ->with('status', count($ids) . ' user(s) deleted successfully.');
    }

    public function jobTitles(Request $request)
    {
        $jobTitles = DB::table('job_titles')
            ->select('id', 'name as title', 'description')
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();
        return view('admin.job.job-titles', compact('jobTitles'));
    }

    public function storeJobTitle(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('job_titles')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.job-titles')
            ->with('status', 'Job title added.');
    }

    public function updateJobTitle(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('job_titles')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.job-titles')
            ->with('status', 'Job title updated.');
    }

    public function deleteJobTitle(int $id)
    {
        DB::table('job_titles')->where('id', $id)->delete();

        return redirect()->route('admin.job-titles')
            ->with('status', 'Job title deleted.');
    }

    public function bulkDeleteJobTitles(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('admin.job-titles')
                ->with('status', 'No job titles selected.');
        }

        DB::table('job_titles')->whereIn('id', $ids)->delete();

        return redirect()->route('admin.job-titles')
            ->with('status', count($ids) . ' job title(s) deleted.');
    }

    public function payGrades()
    {
        $payGrades = DB::table('pay_grades')
            ->select('id', 'name', 'currency')
            ->orderBy('name')
            ->get();
        return view('admin.job.pay-grades', compact('payGrades'));
    }

    public function employmentStatus()
    {
        $statuses = DB::table('employment_statuses')
            ->select('id', 'name')
            ->whereNull('deleted_at')
            ->orderByDesc('id')
            ->get();

        return view('admin.job.employment-status', compact('statuses'));
    }

    /**
     * Store a new employment status.
     */
    public function storeEmploymentStatus(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:employment_statuses,name'],
        ]);

        DB::table('employment_statuses')->insert([
            'name' => $data['name'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.employment-status')
            ->with('status', 'Employment status added successfully.');
    }

    /**
     * Update an existing employment status.
     */
    public function updateEmploymentStatus(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:employment_statuses,name,' . $id],
        ]);

        DB::table('employment_statuses')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.employment-status')
            ->with('status', 'Employment status updated successfully.');
    }

    /**
     * Delete an employment status from the database.
     */
    public function deleteEmploymentStatus(int $id)
    {
        DB::table('employment_statuses')
            ->where('id', $id)
            ->delete(); // Hard delete as per user's previous request for similar entities

        return redirect()->route('admin.employment-status')
            ->with('status', 'Employment status deleted successfully.');
    }

    /**
     * Bulk delete employment statuses from the database.
     */
    public function bulkDeleteEmploymentStatuses(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('admin.employment-status')
                ->with('status', 'No employment statuses selected.');
        }

        DB::table('employment_statuses')->whereIn('id', $ids)->delete();

        return redirect()->route('admin.employment-status')
            ->with('status', count($ids) . ' employment status(es) deleted successfully.');
    }

    public function jobCategories()
    {
        $categories = DB::table('job_categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.job.job-categories', compact('categories'));
    }

    public function workShifts()
    {
        $shifts = DB::table('work_shifts')
            ->select(
                'id',
                'name',
                DB::raw("DATE_FORMAT(start_time, '%h:%i %p') as start_time_formatted"),
                DB::raw("DATE_FORMAT(end_time, '%h:%i %p') as end_time_formatted"),
                'hours_per_day as hours'
            )
            ->orderBy('name')
            ->get();
        return view('admin.job.work-shifts', compact('shifts'));
    }

    public function organizationGeneral()
    {
        // Get organization data from database (assuming first organization or default)
        $organization = DB::table('organizations')->first();
        
        // Get employee count
        $employeeCount = DB::table('employees')->where('status', 'active')->count();
        
        return view('admin.organization.general-information', compact('organization', 'employeeCount'));
    }

    public function updateOrganizationGeneral(Request $request)
    {
        $data = $request->validate([
            'organization_name' => ['required', 'string', 'max:191'],
            'registration_number' => ['nullable', 'string', 'max:100'],
            'tax_id' => ['nullable', 'string', 'max:100'],
            'phone' => ['nullable', 'string', 'max:50'],
            'fax' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:100'],
            'address_street_1' => ['nullable', 'string', 'max:255'],
            'address_street_2' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state_province' => ['nullable', 'string', 'max:100'],
            'zip_postal_code' => ['nullable', 'string', 'max:20'],
            'country' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        // Get the first organization (or create if doesn't exist)
        $organization = DB::table('organizations')->first();
        
        if ($organization) {
            DB::table('organizations')
                ->where('id', $organization->id)
                ->update([
                    'name' => $data['organization_name'],
                    'registration_number' => $data['registration_number'] ?? null,
                    'tax_id' => $data['tax_id'] ?? null,
                    'phone' => $data['phone'] ?? null,
                    'fax' => $data['fax'] ?? null,
                    'email' => $data['email'] ?? null,
                    'address_line1' => $data['address_street_1'] ?? null,
                    'address_line2' => $data['address_street_2'] ?? null,
                    'city' => $data['city'] ?? null,
                    'state' => $data['state_province'] ?? null,
                    'zip_postal_code' => $data['zip_postal_code'] ?? null,
                    'country' => $data['country'] ?? null,
                    'notes' => $data['notes'] ?? null,
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('organizations')->insert([
                'name' => $data['organization_name'],
                'registration_number' => $data['registration_number'] ?? null,
                'tax_id' => $data['tax_id'] ?? null,
                'phone' => $data['phone'] ?? null,
                'fax' => $data['fax'] ?? null,
                'email' => $data['email'] ?? null,
                'address_line1' => $data['address_street_1'] ?? null,
                'address_line2' => $data['address_street_2'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state_province'] ?? null,
                'zip_postal_code' => $data['zip_postal_code'] ?? null,
                'country' => $data['country'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('admin.organization.general-information')
            ->with('status', 'Organization information updated successfully.');
    }

    public function organizationLocations()
    {
        $locations = DB::table('locations')
            ->leftJoin('employees', 'locations.id', '=', 'employees.location_id')
            ->select(
                'locations.id',
                'locations.name',
                'locations.city',
                'locations.country',
                'locations.phone',
                DB::raw('COUNT(employees.id) as num_employees')
            )
            ->groupBy('locations.id', 'locations.name', 'locations.city', 'locations.country', 'locations.phone')
            ->orderBy('locations.name')
            ->get();
        return view('admin.organization.locations', compact('locations'));
    }

    public function organizationStructure()
    {
        return view('admin.organization.structure');
    }

    public function qualificationsSkills()
    {
        $skills = DB::table('qualifications')
            ->where('type', 'skill')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.skills', compact('skills'));
    }

    public function qualificationsEducation()
    {
        $education = DB::table('qualifications')
            ->where('type', 'education')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.education', compact('education'));
    }

    public function qualificationsLicenses()
    {
        $licenses = DB::table('qualifications')
            ->where('type', 'certification')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.licenses', compact('licenses'));
    }

    public function qualificationsLanguages()
    {
        $languages = DB::table('qualifications')
            ->where('type', 'language')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.languages', compact('languages'));
    }

    public function qualificationsMemberships()
    {
        $memberships = DB::table('qualifications')
            ->where('type', 'other')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.memberships', compact('memberships'));
    }

    public function nationalities()
    {
        $nationalities = DB::table('nationalities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.nationalities', compact('nationalities'));
    }

    public function corporateBranding()
    {
        return view('admin.corporate-branding');
    }

    // Configuration methods
    public function emailConfiguration()
    {
        return view('admin.configuration.email-configuration');
    }

    public function emailSubscriptions()
    {
        $subscriptions = DB::table('email_subscriptions')
            ->select('id', 'name as notification_type')
            ->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->subscribers = '';
                return $row;
            });
        return view('admin.configuration.email-subscriptions', compact('subscriptions'));
    }

    public function localization()
    {
        return view('admin.configuration.localization');
    }

    public function languagePackages()
    {
        $languages = DB::table('language_packages')
            ->select('id', 'name', DB::raw("name as native"))
            ->orderBy('sort_order')
            ->get();
        return view('admin.configuration.language-packages', compact('languages'));
    }

    public function moduleConfiguration()
    {
        $labelMap = [
            'admin'       => 'Admin Module',
            'pim'         => 'Pim Module',
            'leave'       => 'Leave Module',
            'time'        => 'Time Module',
            'recruitment' => 'Recruitment Module',
            'performance' => 'Performance Module',
            'directory'   => 'Directory Module',
            'maintenance' => 'Maintenance Module',
            'mobile'      => 'Mobile',
            'claim'       => 'Claim Module',
            'buzz'        => 'Buzz',
        ];

        $modules = DB::table('enabled_modules')
            ->select('id', 'module_key', 'is_enabled')
            ->orderBy('module_key')
            ->get()
            ->map(function ($row) use ($labelMap) {
                $row->name = $labelMap[$row->module_key] ?? ucfirst($row->module_key) . ' Module';
                $row->enabled = (bool)$row->is_enabled;
                return $row;
            });
        return view('admin.configuration.module-configuration', compact('modules'));
    }

    public function socialMediaAuthentication()
    {
        $providers = DB::table('social_providers')
            ->select('id', 'name', 'is_active')
            ->orderBy('name')
            ->get();
        return view('admin.configuration.social-media-authentication', compact('providers'));
    }

    public function oauthClientList()
    {
        $oauthClients = DB::table('oauth_clients')
            ->select('id', 'name', 'redirect_uri', 'is_active')
            ->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->status = $row->is_active ? 'Enabled' : 'Disabled';
                return $row;
            });
        return view('admin.configuration.oauth-client-list', compact('oauthClients'));
    }

    public function ldapConfiguration()
    {
        return view('admin.configuration.ldap-configuration');
    }

    public function roles(Request $request)
    {
        $roles = DB::table('roles')
            ->select('id', 'name', 'slug', 'description', 'is_system')
            ->orderByDesc('id')
            ->get();
        return view('admin.roles', compact('roles'));
    }

    public function storeRole(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:roles,slug'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('roles')->insert([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'description' => $data['description'] ?? null,
            'is_system' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.roles')
            ->with('status', 'Role added successfully.');
    }

    public function updateRole(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'slug' => ['required', 'string', 'max:100', 'unique:roles,slug,' . $id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        DB::table('roles')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('admin.roles')
            ->with('status', 'Role updated successfully.');
    }

    public function deleteRole(int $id)
    {
        // Check if role is system role
        $role = DB::table('roles')->where('id', $id)->first();
        if ($role && $role->is_system == 1) {
            return redirect()->route('admin.roles')
                ->with('error', 'Cannot delete system role.');
        }

        // Check if role is assigned to any user
        $userCount = DB::table('user_roles')->where('role_id', $id)->count();
        if ($userCount > 0) {
            return redirect()->route('admin.roles')
                ->with('error', 'Cannot delete role. It is assigned to ' . $userCount . ' user(s).');
        }

        DB::table('roles')->where('id', $id)->delete();

        return redirect()->route('admin.roles')
            ->with('status', 'Role deleted successfully.');
    }

    public function bulkDeleteRoles(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('admin.roles')
                ->with('status', 'No roles selected.');
        }

        // Filter out system roles
        $systemRoleIds = DB::table('roles')
            ->whereIn('id', $ids)
            ->where('is_system', 1)
            ->pluck('id')
            ->toArray();

        $ids = array_diff($ids, $systemRoleIds);

        if (empty($ids)) {
            return redirect()->route('admin.roles')
                ->with('error', 'Cannot delete system roles.');
        }

        // Check if any role is assigned to users
        $assignedRoles = DB::table('user_roles')
            ->whereIn('role_id', $ids)
            ->distinct()
            ->pluck('role_id')
            ->toArray();

        if (!empty($assignedRoles)) {
            return redirect()->route('admin.roles')
                ->with('error', 'Cannot delete role(s). Some roles are assigned to users.');
        }

        DB::table('roles')->whereIn('id', $ids)->delete();

        return redirect()->route('admin.roles')
            ->with('status', count($ids) . ' role(s) deleted successfully.');
    }
}

