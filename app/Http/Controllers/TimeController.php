<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function index()
    {
        $timesheets = DB::table('timesheets')
            ->join('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->select(
                'timesheets.id',
                'employees.display_name as employee_name',
                DB::raw("CONCAT(timesheets.start_date, ' - ', timesheets.end_date) as timesheet_period"),
                'timesheets.status'
            )
            ->orderByDesc('timesheets.start_date')
            ->limit(20)
            ->get();

        // Get logged-in user's employee information
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        $employeeName = null;
        $employeeId = null;

        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            if ($user && $user->employee_id) {
                $employeeId = $user->employee_id;
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->first();
                if ($employee) {
                    $employeeName = $employee->display_name ?? $employee->first_name . ' ' . $employee->last_name;
                }
            }
        }

        return view('time.time', compact('timesheets', 'employeeName', 'employeeId'));
    }

    public function myTimesheets()
    {
        // TODO: when auth is fully wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $timesheet = DB::table('timesheets')
            ->where('employee_id', $employeeId)
            ->orderByDesc('start_date')
            ->first();

        if ($timesheet) {
            $start = Carbon::parse($timesheet->start_date);
            $end = Carbon::parse($timesheet->end_date);
            $status = ucfirst($timesheet->status);
        } else {
            $today = Carbon::now();
            $start = $today->copy()->startOfWeek(Carbon::MONDAY);
            $end = $today->copy()->endOfWeek(Carbon::SUNDAY);
            $status = 'No Timesheet';
        }

        $days = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day_of_month' => $cursor->format('d'),
                'day_name_short' => $cursor->format('D'),
            ];
            $cursor->addDay();
        }

        $timesheetPeriod = [
            'start' => $start->toDateString(),
            'end' => $end->toDateString(),
        ];

        return view('time.my-timesheets', [
            'days' => $days,
            'timesheetPeriod' => $timesheetPeriod,
            'status' => $status,
        ]);
    }

    public function editMyTimesheet()
    {
        // TODO: when auth is fully wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $timesheet = DB::table('timesheets')
            ->where('employee_id', $employeeId)
            ->orderByDesc('start_date')
            ->first();

        if ($timesheet) {
            $start = Carbon::parse($timesheet->start_date);
            $end = Carbon::parse($timesheet->end_date);
            $timesheetId = $timesheet->id;
        } else {
            $today = Carbon::now();
            $start = $today->copy()->startOfWeek(Carbon::MONDAY);
            $end = $today->copy()->endOfWeek(Carbon::SUNDAY);
            $timesheetId = null;
        }

        $days = [];
        $cursor = $start->copy();
        while ($cursor->lte($end)) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day_of_month' => $cursor->format('d'),
                'day_name_short' => $cursor->format('D'),
            ];
            $cursor->addDay();
        }

        $timesheetPeriod = [
            'start' => $start->toDateString(),
            'end' => $end->toDateString(),
        ];

        $rows = [];

        if ($timesheetId) {
            // Load existing rows grouped by project
            $rawRows = DB::table('timesheet_rows')
                ->leftJoin('time_projects', 'timesheet_rows.project_id', '=', 'time_projects.id')
                ->where('timesheet_rows.timesheet_id', $timesheetId)
                ->select(
                    'timesheet_rows.work_date',
                    'timesheet_rows.hours_worked',
                    'time_projects.name as project_name'
                )
                ->get();

            $grouped = [];
            foreach ($rawRows as $row) {
                $projectName = $row->project_name ?: 'Project';
                if (!isset($grouped[$projectName])) {
                    $grouped[$projectName] = [
                        'project' => $projectName,
                        'activity' => '',
                        'hours' => array_fill(0, count($days), ''),
                    ];
                }

                $dayIndex = Carbon::parse($row->work_date)->diffInDays($start);
                if ($dayIndex >= 0 && $dayIndex < count($days)) {
                    $grouped[$projectName]['hours'][$dayIndex] = (string)$row->hours_worked;
                }
            }

            $rows = array_values($grouped);
        }

        if (empty($rows)) {
            $rows = [
                [
                    'project' => '',
                    'activity' => '',
                    'hours' => array_fill(0, count($days), ''),
                ],
            ];
        }

        return view('time.edit-my-timesheet', [
            'days' => $days,
            'timesheetPeriod' => $timesheetPeriod,
            'rows' => $rows,
        ]);
    }

    /**
     * Attendance - My Records
     */
    public function attendanceMyRecords()
    {
        $today = Carbon::now();
        $selectedDate = request()->get('date', $today->format('Y-m-d'));

        $records = DB::table('attendance_records')
            ->whereDate('punch_in_at', $selectedDate)
            ->orderBy('punch_in_at')
            ->get()
            ->map(function ($row) {
                $duration = 0;
                if ($row->punch_out_at) {
                    $duration = Carbon::parse($row->punch_in_at)
                        ->floatDiffInHours(Carbon::parse($row->punch_out_at));
                }

                return (object) [
                    'punch_in' => Carbon::parse($row->punch_in_at)->format('Y-m-d h:i A'),
                    'punch_in_note' => $row->remarks,
                    'punch_out' => $row->punch_out_at ? Carbon::parse($row->punch_out_at)->format('Y-m-d h:i A') : null,
                    'punch_out_note' => null,
                    'duration' => $duration,
                ];
            });

        $totalDuration = $records->sum('duration');

        return view('time.attendance.my-records', [
            'selectedDate' => $selectedDate,
            'records' => $records,
            'totalDuration' => $totalDuration,
        ]);
    }

    /**
     * Attendance - Punch In/Out
     */
    public function attendancePunchInOut()
    {
        $today = Carbon::now();
        $currentDate = $today->format('Y-m-d');
        $currentTime = $today->format('h:i A'); // 12-hour format with AM/PM
        
        return view('time.attendance.punch-in-out', [
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
        ]);
    }

    /**
     * Attendance - Employee Records
     */
    public function attendanceEmployeeRecords()
    {
        $today = Carbon::now();
        $selectedDate = request()->get('date', $today->format('Y-m-d'));

        $rows = DB::table('attendance_records')
            ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
            ->whereDate('attendance_records.punch_in_at', $selectedDate)
            ->select(
                'employees.display_name as employee_name',
                'attendance_records.punch_in_at',
                'attendance_records.punch_out_at'
            )
            ->orderBy('employees.display_name')
            ->get();

        $records = $rows->groupBy('employee_name')->map(function ($employeeRows, $name) {
            $total = 0;
            foreach ($employeeRows as $row) {
                if ($row->punch_out_at) {
                    $total += Carbon::parse($row->punch_in_at)
                        ->floatDiffInHours(Carbon::parse($row->punch_out_at));
                }
            }

            return (object) [
                'employee_name' => $name,
                'total_duration' => $total,
            ];
        })->values();

        return view('time.attendance.employee-records', [
            'selectedDate' => $selectedDate,
            'records' => $records,
        ]);
    }

    /**
     * Attendance - Configuration
     */
    public function attendanceConfiguration()
    {
        return view('time.attendance.configuration');
    }

    /**
     * Reports - Project Reports
     */
    public function projectReports()
    {
        return view('time.reports.project-reports');
    }

    /**
     * Reports - Employee Reports
     */
    public function employeeReports()
    {
        return view('time.reports.employee-reports');
    }

    /**
     * Reports - Attendance Summary
     */
    public function attendanceSummary()
    {
        return view('time.reports.attendance-summary');
    }

    /**
     * Project Info - Customers
     */
    public function projectInfoCustomers()
    {
        $customers = DB::table('time_customers')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return view('time.project-info.customers', compact('customers'));
    }

    /**
     * Store a new customer.
     */
    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::table('time_customers')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer added.');
    }

    /**
     * Update an existing customer.
     */
    public function updateCustomer(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::table('time_customers')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer updated.');
    }

    /**
     * Delete a customer from the database.
     */
    public function deleteCustomer(int $id)
    {
        DB::table('time_customers')
            ->where('id', $id)
            ->delete();

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer deleted.');
    }

    /**
     * Bulk delete customers from the database.
     */
    public function bulkDeleteCustomers(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->toArray();

        if (count($ids) > 0) {
            DB::table('time_customers')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('time.project-info.customers')
            ->with('status', count($ids) . ' customer(s) deleted.');
    }

    /**
     * Project Info - Projects
     */
    public function projectInfoProject(Request $request)
    {
        $query = DB::table('time_projects')
            ->leftJoin('time_customers', 'time_projects.customer_id', '=', 'time_customers.id')
            ->leftJoin('time_project_assignments', 'time_projects.id', '=', 'time_project_assignments.project_id')
            ->leftJoin('employees', 'time_project_assignments.employee_id', '=', 'employees.id')
            ->select(
                'time_projects.id',
                'time_projects.customer_id',
                'time_projects.name as project_name',
                'time_projects.description',
                'time_customers.name as customer_name',
                DB::raw("GROUP_CONCAT(DISTINCT employees.display_name ORDER BY employees.display_name SEPARATOR ', ') as admins")
            )
            ->groupBy('time_projects.id', 'time_projects.customer_id', 'time_projects.name', 'time_projects.description', 'time_customers.name');

        // Apply filters
        if ($request->filled('customer_name')) {
            $query->where('time_customers.name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->filled('project')) {
            $query->where('time_projects.name', 'like', '%' . $request->project . '%');
        }

        if ($request->filled('project_admin')) {
            $query->havingRaw("GROUP_CONCAT(DISTINCT employees.display_name ORDER BY employees.display_name SEPARATOR ', ') LIKE ?", ['%' . $request->project_admin . '%']);
        }

        $projects = $query->orderBy('time_projects.name')->get();

        // Get customers for dropdown
        $customers = DB::table('time_customers')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // Get employees for dropdown
        $employees = DB::table('employees')
            ->select('id', 'display_name', 'first_name', 'last_name')
            ->orderBy('display_name')
            ->get();

        // Get current project admins for editing
        $projectAdmins = [];
        $adminAssignments = DB::table('time_project_assignments')
            ->where('role', 'Project Admin')
            ->get();
        
        foreach ($adminAssignments as $assignment) {
            $projectAdmins[$assignment->project_id] = $assignment->employee_id;
        }

        return view('time.project-info.projects', compact('projects', 'customers', 'employees', 'projectAdmins'));
    }

    /**
     * Store a new project.
     */
    public function storeProject(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:time_customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'project_admin_id' => ['nullable', 'exists:employees,id'],
        ]);

        // Insert project
        $projectId = DB::table('time_projects')->insertGetId([
            'customer_id' => $data['customer_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign project admin if selected
        if (!empty($data['project_admin_id'])) {
            DB::table('time_project_assignments')->insert([
                'project_id' => $projectId,
                'employee_id' => $data['project_admin_id'],
                'role' => 'Project Admin',
                'created_at' => now(),
            ]);
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project added.');
    }

    /**
     * Update an existing project.
     */
    public function updateProject(Request $request, int $id)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:time_customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'project_admin_id' => ['nullable', 'exists:employees,id'],
        ]);

        // Update project
        DB::table('time_projects')
            ->where('id', $id)
            ->update([
                'customer_id' => $data['customer_id'] ?? null,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        // Remove existing project admin assignments
        DB::table('time_project_assignments')
            ->where('project_id', $id)
            ->where('role', 'Project Admin')
            ->delete();

        // Assign new project admin if selected
        if (!empty($data['project_admin_id'])) {
            // Check if assignment already exists with different role
            $existingAssignment = DB::table('time_project_assignments')
                ->where('project_id', $id)
                ->where('employee_id', $data['project_admin_id'])
                ->first();

            if ($existingAssignment) {
                // Update existing assignment to Project Admin role
                DB::table('time_project_assignments')
                    ->where('project_id', $id)
                    ->where('employee_id', $data['project_admin_id'])
                    ->update([
                        'role' => 'Project Admin',
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert new assignment
                DB::table('time_project_assignments')->insert([
                    'project_id' => $id,
                    'employee_id' => $data['project_admin_id'],
                    'role' => 'Project Admin',
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project updated.');
    }

    /**
     * Delete a project from the database.
     */
    public function deleteProject(int $id)
    {
        DB::table('time_projects')
            ->where('id', $id)
            ->delete();

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project deleted.');
    }

    /**
     * Bulk delete projects from the database.
     */
    public function bulkDeleteProjects(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->toArray();

        if (count($ids) > 0) {
            DB::table('time_projects')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', count($ids) . ' project(s) deleted.');
    }
}

