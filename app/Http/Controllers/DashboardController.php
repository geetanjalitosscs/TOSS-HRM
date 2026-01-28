<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $activeEmployees = DB::table('employees')->where('status', 'active')->count();
        $totalEmployees = DB::table('employees')->count();
        $terminatedEmployees = DB::table('employees')->where('status', 'terminated')->count();

        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        // Get employee_id from users table
        $employeeId = null;
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            $employeeId = $user->employee_id ?? null;
        }

        $pendingSelfReviews = DB::table('performance_reviews')
            ->when($employeeId, function ($q) use ($employeeId) {
                $q->where('employee_id', $employeeId);
            })
            ->whereIn('status', ['not_started', 'in_progress'])
            ->count();

        $pendingCandidates = DB::table('candidate_applications')
            ->whereIn('status', ['interview_scheduled', 'shortlisted'])
            ->count();

        $latestBuzz = DB::table('buzz_posts')
            ->join('users', 'buzz_posts.author_id', '=', 'users.id')
            ->select(
                'buzz_posts.id',
                'buzz_posts.title',
                'buzz_posts.body as content',
                'buzz_posts.created_at',
                'users.username as author_name'
            )
            ->orderByDesc('buzz_posts.created_at')
            ->limit(3)
            ->get();

        // Time at Work - Today's punch in/out
        $todayAttendance = null;
        $todayDuration = 0;
        if ($employeeId) {
            $today = Carbon::today();
            $todayAttendance = DB::table('attendance_records')
                ->where('employee_id', $employeeId)
                ->whereDate('punch_in_at', $today)
                ->orderByDesc('punch_in_at')
                ->first();
            
            if ($todayAttendance && $todayAttendance->punch_out_at) {
                $punchIn = Carbon::parse($todayAttendance->punch_in_at);
                $punchOut = Carbon::parse($todayAttendance->punch_out_at);
                $todayDuration = $punchIn->floatDiffInHours($punchOut);
            } elseif ($todayAttendance && !$todayAttendance->punch_out_at) {
                $punchIn = Carbon::parse($todayAttendance->punch_in_at);
                $now = Carbon::now();
                $todayDuration = $punchIn->floatDiffInHours($now);
            }
        }

        // Time at Work - This Week's data
        $weekData = [];
        if ($employeeId) {
            $today = Carbon::today();
            $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
            $weekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);
            
            // Get attendance records for this week
            $weekRecords = DB::table('attendance_records')
                ->where('employee_id', $employeeId)
                ->whereBetween(DB::raw('DATE(punch_in_at)'), [$weekStart->toDateString(), $weekEnd->toDateString()])
                ->get();
            
            // Group by day of week (0=Monday, 6=Sunday)
            $dayTotals = [];
            foreach ($weekRecords as $record) {
                $punchIn = Carbon::parse($record->punch_in_at);
                $dayOfWeek = ($punchIn->dayOfWeek + 6) % 7; // Convert to Monday=0, Sunday=6
                
                $duration = 0;
                if ($record->punch_out_at) {
                    $punchOut = Carbon::parse($record->punch_out_at);
                    $duration = $punchIn->floatDiffInHours($punchOut);
                } else {
                    // If not punched out, calculate until now (if today) or end of day
                    if ($punchIn->isToday()) {
                        $duration = $punchIn->floatDiffInHours(Carbon::now());
                    } else {
                        $endOfDay = $punchIn->copy()->endOfDay();
                        $duration = $punchIn->floatDiffInHours($endOfDay);
                    }
                }
                
                if (!isset($dayTotals[$dayOfWeek])) {
                    $dayTotals[$dayOfWeek] = 0;
                }
                $dayTotals[$dayOfWeek] += $duration;
            }
            
            // Build week data array (Monday to Sunday)
            for ($i = 0; $i < 7; $i++) {
                $hours = $dayTotals[$i] ?? 0;
                $hoursInt = floor($hours);
                $minutesInt = floor(($hours - $hoursInt) * 60);
                $weekData[] = [
                    'hours' => $hours,
                    'hoursFormatted' => $hoursInt . 'h ' . $minutesInt . 'm',
                    'height' => min(100, ($hours / 8) * 100) // Max 8 hours = 100% height
                ];
            }
        } else {
            // Default empty data
            for ($i = 0; $i < 7; $i++) {
                $weekData[] = [
                    'hours' => 0,
                    'hoursFormatted' => '0h 0m',
                    'height' => 0
                ];
            }
        }

        // Employees on Leave Today
        $today = Carbon::today();
        $employeesOnLeave = DB::table('leave_applications')
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->where('leave_applications.status', 'approved')
            ->whereDate('leave_applications.start_date', '<=', $today)
            ->whereDate('leave_applications.end_date', '>=', $today)
            ->select(
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_applications.start_date',
                'leave_applications.end_date'
            )
            ->orderBy('employees.display_name')
            ->get();

        // Employee Distribution by Sub Unit
        $subUnitDistribution = DB::table('employees')
            ->join('employee_job_details', 'employees.id', '=', 'employee_job_details.employee_id')
            ->leftJoin('organization_units', 'employee_job_details.organization_unit_id', '=', 'organization_units.id')
            ->where('employees.status', 'active')
            ->select(
                DB::raw('COALESCE(organization_units.name, "Unassigned") as sub_unit'),
                DB::raw('COUNT(employees.id) as count')
            )
            ->groupBy('organization_units.name')
            ->get();

        $totalActive = $subUnitDistribution->sum('count');
        $subUnitData = $subUnitDistribution->map(function ($item) use ($totalActive) {
            $percentage = $totalActive > 0 ? ($item->count / $totalActive) * 100 : 0;
            return [
                'label' => $item->sub_unit,
                'count' => $item->count,
                'value' => round($percentage, 2)
            ];
        })->toArray();

        // Employee Distribution by Location
        $locationDistribution = DB::table('employees')
            ->join('employee_job_details', 'employees.id', '=', 'employee_job_details.employee_id')
            ->leftJoin('locations', 'employee_job_details.location_id', '=', 'locations.id')
            ->where('employees.status', 'active')
            ->select(
                DB::raw('COALESCE(locations.name, "Unassigned") as location'),
                DB::raw('COUNT(employees.id) as count')
            )
            ->groupBy('locations.name')
            ->get();

        $locationData = $locationDistribution->map(function ($item) use ($totalActive) {
            $percentage = $totalActive > 0 ? ($item->count / $totalActive) * 100 : 0;
            return [
                'label' => $item->location,
                'count' => $item->count,
                'value' => round($percentage, 2)
            ];
        })->toArray();

        return view('dashboard.dashboard', compact(
            'activeEmployees',
            'totalEmployees',
            'terminatedEmployees',
            'pendingSelfReviews',
            'pendingCandidates',
            'latestBuzz',
            'todayAttendance',
            'todayDuration',
            'weekData',
            'employeesOnLeave',
            'subUnitData',
            'locationData'
        ));
    }
}
