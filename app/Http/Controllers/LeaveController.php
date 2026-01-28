<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeaveController extends Controller
{
    public function index()
    {
        return redirect()->route('leave.leave-list');
    }

    public function apply()
    {
        return view('leave.apply');
    }

    public function myLeave()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $leaves = DB::table('leave_applications')
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->select(
                'leave_applications.id',
                DB::raw("DATE_FORMAT(leave_applications.start_date, '%Y-%m-%d') as date"),
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_applications.total_days as number_of_days',
                'leave_applications.status',
                'leave_applications.reason as comments'
            )
            ->where('leave_applications.employee_id', $employeeId)
            ->orderByDesc('leave_applications.start_date')
            ->get();

        return view('leave.my-leave', compact('leaves'));
    }

    public function leaveList()
    {
        $leaves = DB::table('leave_applications')
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('leave_entitlements', function ($join) {
                $join->on('leave_entitlements.employee_id', '=', 'leave_applications.employee_id')
                    ->on('leave_entitlements.leave_type_id', '=', 'leave_applications.leave_type_id');
            })
            ->select(
                'leave_applications.id',
                DB::raw("DATE_FORMAT(leave_applications.start_date, '%Y-%m-%d') as date"),
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                DB::raw("COALESCE(leave_entitlements.days_entitled - leave_entitlements.days_used, 0) as leave_balance"),
                'leave_applications.total_days as number_of_days',
                'leave_applications.status',
                'leave_applications.reason as comments'
            )
            ->orderByDesc('leave_applications.start_date')
            ->get();

        return view('leave.leave-list', compact('leaves'));
    }

    public function assignLeave()
    {
        return view('leave.assign-leave');
    }

    // Entitlements
    public function addEntitlement()
    {
        return view('leave.add-entitlement');
    }

    public function myEntitlements()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $entitlements = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->select(
                'leave_types.name as leave_type',
                'leave_entitlements.days_entitled',
                'leave_entitlements.days_used',
                DB::raw('(leave_entitlements.days_entitled - leave_entitlements.days_used) as balance')
            )
            ->where('leave_entitlements.employee_id', $employeeId)
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.my-entitlements', compact('entitlements'));
    }

    public function employeeEntitlements()
    {
        // Fetch all employee entitlements with employee and leave type details
        $entitlements = DB::table('leave_entitlements')
            ->join('employees', 'leave_entitlements.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->select(
                'leave_entitlements.id',
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_entitlements.days_entitled',
                'leave_entitlements.days_used',
                DB::raw('(leave_entitlements.days_entitled - leave_entitlements.days_used) as balance')
            )
            ->orderBy('employees.display_name')
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.employee-entitlements', compact('entitlements'));
    }

    // Reports
    public function entitlementsUsageReport()
    {
        return view('leave.entitlements-usage-report');
    }

    public function myEntitlementsUsageReport()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $reportData = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('leave_applications', function ($join) use ($employeeId) {
                $join->on('leave_applications.employee_id', '=', 'leave_entitlements.employee_id')
                    ->on('leave_applications.leave_type_id', '=', 'leave_entitlements.leave_type_id');
            })
            ->select(
                'leave_types.name as leave_type',
                'leave_entitlements.days_entitled',
                DB::raw('COALESCE(SUM(leave_applications.total_days), 0) as days_taken'),
                DB::raw('(leave_entitlements.days_entitled - COALESCE(SUM(leave_applications.total_days), 0)) as balance')
            )
            ->where('leave_entitlements.employee_id', $employeeId)
            ->groupBy('leave_types.name', 'leave_entitlements.days_entitled')
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.my-entitlements-usage-report', compact('reportData'));
    }

    // Configure
    public function leaveTypes()
    {
        $leaveTypes = DB::table('leave_types')
            ->select('id', 'name', 'code', 'is_paid', 'requires_approval', 'max_per_year', 'carry_forward')
            ->orderBy('name')
            ->get();

        return view('leave.leave-types', compact('leaveTypes'));
    }

    public function leavePeriod()
    {
        return view('leave.leave-period');
    }

    public function workWeek()
    {
        $dayNames = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        $rows = DB::table('work_weeks')
            ->whereNull('location_id')
            ->orderBy('day_of_week')
            ->get();

        if ($rows->isEmpty()) {
            // Fallback to a default pattern if no DB rows exist yet
            $rows = collect(range(1, 7))->map(function ($day) {
                return (object)[
                    'day_of_week'   => $day,
                    'is_working_day'=> $day <= 5 ? 1 : 0,
                    'hours_per_day' => $day <= 5 ? 8.0 : 0.0,
                ];
            });
        }

        $days = $rows->map(function ($row) use ($dayNames) {
            $value = 'non_working';
            if ($row->is_working_day) {
                $value = $row->hours_per_day >= 7.5 ? 'full_day' : 'half_day';
            }

            $label = match ($value) {
                'full_day'    => 'Full Day',
                'half_day'    => 'Half Day',
                default       => 'Non-working Day',
            };

            return (object)[
                'name'  => $dayNames[$row->day_of_week] ?? 'Day ' . $row->day_of_week,
                'value' => $value,
                'label' => $label,
            ];
        });

        return view('leave.work-week', compact('days'));
    }

    public function holidays()
    {
        $holidays = DB::table('holidays')
            ->select(
                'id',
                'name',
                DB::raw("DATE_FORMAT(holiday_date, '%Y-%m-%d') as date"),
                DB::raw("CASE WHEN is_recurring = 1 THEN 'Recurring' ELSE 'Non-Recurring' END as type"),
                DB::raw("CASE WHEN is_recurring = 1 THEN 'Yes' ELSE 'No' END as repeats")
            )
            ->orderBy('holiday_date')
            ->get();

        return view('leave.holidays', compact('holidays'));
    }
}

