<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class TimeController extends Controller
{
    public function index()
    {
        $timesheets = [
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2026-05-01 - 2026-11-01'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2023-16-01 - 2023-22-01'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2022-15-08 - 2022-21-08'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2020-14-09 - 2020-20-09'],
        ];
        return view('time.time', compact('timesheets'));
    }

    public function myTimesheets()
    {
        $today = Carbon::now();
        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $days[] = [
                'date' => $date,
                'day_of_month' => $date->format('d'),
                'day_name_short' => $date->format('D'),
            ];
        }

        $timesheetPeriod = [
            'start' => $weekStart->format('Y-m-d'),
            'end' => $weekEnd->format('Y-m-d'),
        ];

        $status = 'Not Submitted';

        return view('time.my-timesheets', [
            'days' => $days,
            'timesheetPeriod' => $timesheetPeriod,
            'status' => $status,
        ]);
    }

    public function editMyTimesheet()
    {
        $today = Carbon::now();
        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = $weekStart->copy()->addDays($i);
            $days[] = [
                'date' => $date,
                'day_of_month' => $date->format('d'),
                'day_name_short' => $date->format('D'),
            ];
        }

        $timesheetPeriod = [
            'start' => $weekStart->format('Y-m-d'),
            'end' => $weekEnd->format('Y-m-d'),
        ];

        // Static dummy row for now (no persistence yet)
        $rows = [
            [
                'project' => '',
                'activity' => '',
                'hours' => array_fill(0, 7, ''),
            ],
        ];

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
        
        // Sample attendance records data matching the image
        $records = [
            [
                'punch_in' => '2026-23-01 02:36 PM GMT +05:30',
                'punch_in_note' => 'Arrived on time',
                'punch_out' => '2026-23-01 02:51 PM GMT +05:30',
                'punch_out_note' => '',
                'duration' => 0.25,
            ],
            [
                'punch_in' => '2026-23-01 01:51 PM GMT +05:30',
                'punch_in_note' => '',
                'punch_out' => '2026-23-01 02:10 PM GMT +05:30',
                'punch_out_note' => 'im out',
                'duration' => 0.32,
            ],
            [
                'punch_in' => '2026-23-01 10:00 AM GMT +05:30',
                'punch_in_note' => '',
                'punch_out' => '2026-23-01 10:06 AM GMT +05:30',
                'punch_out_note' => '',
                'duration' => 0.10,
            ],
        ];
        
        $totalDuration = array_sum(array_column($records, 'duration'));
        
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
        $selectedDate = request()->get('date', $today->format('Y-d-m')); // Format: YYYY-DD-MM as shown in image
        
        // Sample employee attendance records data
        $records = [
            [
                'employee_name' => 'TestFN1769171034965 TestLN',
                'total_duration' => 0.00,
            ],
            [
                'employee_name' => 'TestFN1769171012749 TestLN',
                'total_duration' => 0.00,
            ],
            [
                'employee_name' => 'A8DCo 010Z',
                'total_duration' => 0.00,
            ],
        ];
        
        // Generate more sample records to reach 127 total
        for ($i = 4; $i <= 127; $i++) {
            $records[] = [
                'employee_name' => 'Employee ' . $i . ' Name',
                'total_duration' => 0.00,
            ];
        }
        
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
}

