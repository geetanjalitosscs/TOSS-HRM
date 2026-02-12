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
        // NOTE: We want to count:
        // - Holidays whose date is in the current year, AND
        // - Holidays marked as recurring (is_recurring = 1), even if their original year is different.
        $currentYear = Carbon::now()->year;
        $holidaysData = DB::table('holidays')
            ->where(function ($q) use ($currentYear) {
                $q->whereYear('holiday_date', $currentYear)
                  ->orWhere('is_recurring', 1);
            })
            ->orderBy('holiday_date')
            ->get()
            ->groupBy(function ($item) {
                // Group by month short name (Jan, Feb, ...) based on the holiday_date
                return Carbon::parse($item->holiday_date)->format('M');
            })
            ->map(function ($monthHolidays, $month) {
                return [
                    'month' => $month,
                    'count' => $monthHolidays->count(),
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

        // Buzz activity - recent 5 items (posts or comments)
        $totalBuzzPosts = DB::table('buzz_posts')->count();

        $recentBuzzActivities = DB::query()
            ->fromSub(function ($query) {
                // Posts
                $query->from(function ($q) {
                    $q->from('buzz_posts')
                        ->join('users', 'buzz_posts.author_id', '=', 'users.id')
                        ->selectRaw('buzz_posts.id as post_id, buzz_posts.created_at as activity_at, users.username, buzz_posts.body as content, "post" as activity_type');
                }, 'p')
                // UNION ALL with comments
                ->unionAll(
                    DB::table('buzz_post_comments')
                        ->join('buzz_posts', 'buzz_post_comments.post_id', '=', 'buzz_posts.id')
                        ->join('users', 'buzz_post_comments.author_id', '=', 'users.id')
                        ->selectRaw('buzz_posts.id as post_id, buzz_post_comments.created_at as activity_at, users.username, buzz_post_comments.body as content, "comment" as activity_type')
                );
            }, 'activities')
            ->orderByDesc('activity_at')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    // Always link to the post
                    'id' => $item->post_id,
                    'username' => $item->username,
                    // Trim content to keep card height same
                    'content' => mb_strimwidth($item->content ?? '', 0, 80, '...'),
                    'timestamp' => Carbon::parse($item->activity_at)->timezone('Asia/Kolkata')->format('M d, Y h:i A'),
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
            'recentBuzzActivities'
        ));
    }
}