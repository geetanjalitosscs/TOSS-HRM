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

    public function kpis(Request $request)
    {
        $query = DB::table('kpis')
            ->select('id', 'name', 'description', 'weight');

        if ($request->filled('indicator')) {
            $query->where('name', 'like', '%' . $request->input('indicator') . '%');
        }

        if ($request->filled('job_title')) {
            $query->where('description', 'like', '%' . $request->input('job_title') . '%');
        }

        if ($request->filled('min_rate')) {
            $query->where('weight', '>=', (int) $request->input('min_rate'));
        }

        if ($request->filled('max_rate')) {
            $query->where('weight', '<=', (int) $request->input('max_rate'));
        }

        $kpis = $query->orderBy('name')->get();

        return view('performance.kpis', compact('kpis'));
    }

    public function storeKpi(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:0'],
        ]);

        DB::table('kpis')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'weight' => $data['weight'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('performance.kpis')
            ->with('status', 'KPI added successfully.');
    }

    public function updateKpi(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:0'],
        ]);

        DB::table('kpis')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'weight' => $data['weight'],
                'updated_at' => now(),
            ]);

        return redirect()->route('performance.kpis')
            ->with('status', 'KPI updated successfully.');
    }

    public function deleteKpi(int $id)
    {
        DB::table('kpis')
            ->where('id', $id)
            ->delete();

        return redirect()->route('performance.kpis')
            ->with('status', 'KPI deleted successfully.');
    }

    public function bulkDeleteKpis(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));

        if (!empty($ids)) {
            DB::table('kpis')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('performance.kpis')
            ->with('status', 'Selected KPIs deleted successfully.');
    }

    public function trackers(Request $request)
    {
        $query = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'employees.id as employee_id',
                'performance_cycles.id as cycle_id',
                'performance_cycles.name as tracker',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date"),
                'performance_reviews.status'
            );

        if ($request->filled('employee_name')) {
            $name = $request->input('employee_name');
            $query->where('employees.display_name', 'like', '%' . $name . '%');
        }

        if ($request->filled('tracker')) {
            $tracker = $request->input('tracker');
            $query->where('performance_cycles.name', 'like', '%' . $tracker . '%');
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('performance_reviews.status', $status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('performance_reviews.created_at', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('performance_reviews.created_at', '<=', $request->input('to_date'));
        }

        $trackers = $query
            ->orderByDesc('performance_reviews.created_at')
            ->get();

        $employees = DB::table('employees')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as display_name"))
            ->orderBy('display_name')
            ->get();

        $cycles = DB::table('performance_cycles')
            ->select('id', 'name')
            ->orderByDesc('start_date')
            ->get();

        return view('performance.trackers', compact('trackers', 'employees', 'cycles'));
    }

    public function storeTracker(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'status' => ['nullable', 'string', 'in:not_started,in_progress,completed,approved'],
        ]);

        DB::table('performance_reviews')->insert([
            'employee_id' => $data['employee_id'],
            'cycle_id' => $data['cycle_id'],
            'reviewer_id' => null,
            'status' => $data['status'] ?? 'not_started',
            'overall_rating' => null,
            'comments' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('performance.trackers')
            ->with('status', 'Tracker added successfully.');
    }

    public function updateTracker(Request $request, int $id)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'status' => ['nullable', 'string', 'in:not_started,in_progress,completed,approved'],
        ]);

        DB::table('performance_reviews')
            ->where('id', $id)
            ->update([
                'employee_id' => $data['employee_id'],
                'cycle_id' => $data['cycle_id'],
                'status' => $data['status'] ?? 'not_started',
                'updated_at' => now(),
            ]);

        return redirect()->route('performance.trackers')
            ->with('status', 'Tracker updated successfully.');
    }

    public function deleteTracker(int $id)
    {
        DB::table('performance_reviews')
            ->where('id', $id)
            ->delete();

        return redirect()->route('performance.trackers')
            ->with('status', 'Tracker deleted successfully.');
    }

    public function bulkDeleteTrackers(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));

        if (!empty($ids)) {
            DB::table('performance_reviews')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('performance.trackers')
            ->with('status', 'Selected trackers deleted successfully.');
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

