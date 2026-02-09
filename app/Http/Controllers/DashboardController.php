<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalEmployees = DB::table('employees')->count();

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

        // Work Week Data
        $workWeekData = DB::table('work_weeks')
            ->whereNull('location_id')
            ->orderBy('day_of_week')
            ->get()
            ->map(function ($item) {
                $dayNames = ['', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            return [
                    'day' => $dayNames[$item->day_of_week] ?? 'Day ' . $item->day_of_week,
                    'is_working' => (bool)$item->is_working_day,
                    'hours' => (float)$item->hours_per_day
            ];
        })->toArray();

        // Holidays Data (by month for current year)
        $currentYear = Carbon::now()->year;
        $holidaysData = DB::table('holidays')
            ->whereYear('holiday_date', $currentYear)
            ->orderBy('holiday_date')
            ->get()
            ->groupBy(function ($item) {
                return Carbon::parse($item->holiday_date)->format('M');
            })
            ->map(function ($monthHolidays, $month) {
                return [
                    'month' => $month,
                    'count' => $monthHolidays->count()
                ];
            })
            ->values()
            ->toArray();

        // Job Titles Distribution - Show all job titles
        $jobTitlesData = DB::table('job_titles')
            ->leftJoin('employees', 'job_titles.id', '=', 'employees.job_title_id')
            ->whereNull('employees.deleted_at')
            ->select(
                'job_titles.name as job_title',
                DB::raw('COUNT(CASE WHEN employees.status = "active" THEN employees.id END) as count')
            )
            ->groupBy('job_titles.id', 'job_titles.name')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
            return [
                    'label' => $item->job_title,
                    'count' => (int)$item->count
            ];
        })->toArray();
        
        // Debug: Log the job titles data
        \Log::info('Job Titles Data: ' . json_encode($jobTitlesData));
        
        // Calculate total job titles
        $totalJobTitles = count($jobTitlesData);

        // Buzz activity - recent posts
        $totalBuzzPosts = DB::table('buzz_posts')->count();

        $recentBuzzPosts = DB::table('buzz_posts')
            ->join('users', 'buzz_posts.author_id', '=', 'users.id')
            ->select(
                'buzz_posts.id',
                'buzz_posts.body as content',
                'buzz_posts.created_at',
                'users.username'
            )
            ->orderByDesc('buzz_posts.created_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'username' => $item->username,
                    'content' => mb_strimwidth($item->content ?? '', 0, 80, '...'),
                    'timestamp' => Carbon::parse($item->created_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A'),
                ];
            })
            ->toArray();

        return view('dashboard.dashboard', compact(
            'totalEmployees',
            'employeesOnLeave',
            'workWeekData',
            'holidaysData',
            'jobTitlesData',
            'totalJobTitles',
            'totalBuzzPosts',
            'recentBuzzPosts'
        ));
    }
}