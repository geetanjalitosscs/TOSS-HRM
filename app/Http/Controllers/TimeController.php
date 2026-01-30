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
     * Project Info - Projects
     */
    public function projectInfoProject()
    {
        $projects = DB::table('time_projects')
            ->leftJoin('time_customers', 'time_projects.customer_id', '=', 'time_customers.id')
            ->leftJoin('time_project_assignments', 'time_projects.id', '=', 'time_project_assignments.project_id')
            ->leftJoin('employees', 'time_project_assignments.employee_id', '=', 'employees.id')
            ->select(
                'time_projects.id',
                'time_customers.name as customer_name',
                'time_projects.name as project_name',
                DB::raw("GROUP_CONCAT(DISTINCT employees.display_name ORDER BY employees.display_name SEPARATOR ', ') as admins")
            )
            ->groupBy('time_projects.id', 'time_customers.name', 'time_projects.name')
            ->orderBy('time_projects.name')
            ->get();

        return view('time.project-info.projects', compact('projects'));
    }
}

