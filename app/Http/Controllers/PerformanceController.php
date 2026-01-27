<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PerformanceController extends Controller
{
    public function index()
    {
        $reviews = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'job_titles.name as job_title',
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.status as review_status'
            )
            ->orderByDesc('performance_cycles.end_date')
            ->limit(20)
            ->get();

        return view('performance.performance', compact('reviews'));
    }

    public function myTrackers()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $trackers = DB::table('performance_reviews')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->where('performance_reviews.employee_id', $employeeId)
            ->select(
                'performance_reviews.id',
                'performance_cycles.name as tracker',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date")
            )
            ->orderByDesc('performance_reviews.created_at')
            ->get();

        return view('performance.my-trackers', compact('trackers'));
    }

    public function employeeTrackers()
    {
        $trackers = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee_name',
                'performance_cycles.name as tracker',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date")
            )
            ->orderBy('employees.display_name')
            ->get();

        return view('performance.employee-trackers', compact('trackers'));
    }

    public function kpis()
    {
        $kpis = DB::table('kpis')
            ->select(
                'id',
                'name',
                'description',
                'weight'
            )
            ->orderBy('name')
            ->get();

        return view('performance.kpis', compact('kpis'));
    }

    public function trackers()
    {
        $trackers = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'performance_cycles.name as tracker',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date")
            )
            ->orderByDesc('performance_reviews.created_at')
            ->get();

        return view('performance.trackers', compact('trackers'));
    }

    public function myReviews()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $reviews = DB::table('performance_reviews')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->where('performance_reviews.employee_id', $employeeId)
            ->select(
                'performance_reviews.id',
                'job_titles.name as job_title',
                DB::raw("COALESCE(organization_units.name, '-') as sub_unit"),
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                DB::raw("CASE WHEN performance_reviews.status IN ('in_progress','completed') THEN 'Activated' ELSE UPPER(performance_reviews.status) END as self_evaluation_status"),
                DB::raw("UPPER(performance_reviews.status) as review_status")
            )
            ->orderByDesc('performance_cycles.end_date')
            ->get();

        return view('performance.my-reviews', compact('reviews'));
    }

    public function employeeReviews()
    {
        $reviews = DB::table('performance_reviews')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'job_titles.name as job_title',
                DB::raw("COALESCE(organization_units.name, '-') as sub_unit"),
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                DB::raw("UPPER(performance_reviews.status) as review_status")
            )
            ->orderBy('employees.display_name')
            ->get();

        return view('performance.employee-reviews', compact('reviews'));
    }
}

