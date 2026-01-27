<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $activeEmployees = DB::table('employees')->where('status', 'active')->count();
        $totalEmployees = DB::table('employees')->count();
        $terminatedEmployees = DB::table('employees')->where('status', 'terminated')->count();

        $authUser = session('auth_user');
        $employeeId = $authUser['id'] ?? null;

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

        return view('dashboard.dashboard', compact(
            'activeEmployees',
            'totalEmployees',
            'terminatedEmployees',
            'pendingSelfReviews',
            'pendingCandidates',
            'latestBuzz'
        ));
    }
}
