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

        $employees = DB::table('employees')
            ->whereNull('deleted_at')
            ->select('id', 'display_name')
            ->orderBy('display_name')
            ->get();

        $cycles = DB::table('performance_cycles')
            ->select('id', 'name', 'start_date', 'end_date')
            ->orderByDesc('end_date')
            ->get()
            ->map(function($cycle) {
                $cycle->name = $cycle->name . ' (' . date('Y-m-d', strtotime($cycle->start_date)) . ' - ' . date('Y-m-d', strtotime($cycle->end_date)) . ')';
                return $cycle;
            });

        return view('performance.performance', compact('reviews', 'employees', 'cycles'));
    }

    public function storeReview(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'reviewer_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['required', 'string', 'in:pending,in_progress,completed,cancelled'],
        ]);

        DB::table('performance_reviews')->insert([
            'employee_id' => $data['employee_id'],
            'cycle_id' => $data['cycle_id'],
            'reviewer_id' => $data['reviewer_id'] ?? null,
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('performance')
            ->with('status', 'Performance review added successfully.');
    }

    public function updateReview(Request $request, int $id)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'reviewer_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['required', 'string', 'in:pending,in_progress,completed,cancelled'],
        ]);

        DB::table('performance_reviews')
            ->where('id', $id)
            ->update([
                'employee_id' => $data['employee_id'],
                'cycle_id' => $data['cycle_id'],
                'reviewer_id' => $data['reviewer_id'] ?? null,
                'status' => $data['status'],
                'updated_at' => now(),
            ]);

        return redirect()->route('performance')
            ->with('status', 'Performance review updated successfully.');
    }

    public function deleteReview(int $id)
    {
        DB::table('performance_reviews')->where('id', $id)->delete();

        return redirect()->route('performance')
            ->with('status', 'Performance review deleted successfully.');
    }

    public function bulkDeleteReviews(Request $request)
    {
        $ids = explode(',', $request->input('ids', ''));
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return redirect()->route('performance')
                ->with('error', 'No reviews selected for deletion.');
        }

        DB::table('performance_reviews')->whereIn('id', $ids)->delete();

        return redirect()->route('performance')
            ->with('status', count($ids) . ' review(s) deleted successfully.');
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

