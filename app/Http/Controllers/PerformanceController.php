<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\PerformanceRatingService;

class PerformanceController extends Controller
{
    protected $ratingService;

    public function __construct(PerformanceRatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Get current logged-in user's employee_id
     */
    private function getCurrentEmployeeId(): ?int
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        if (!$userId) {
            return null;
        }

        $user = DB::table('users')
            ->where('id', $userId)
            ->select('employee_id')
            ->first();

        return $user->employee_id ?? null;
    }
    public function index(Request $request)
    {
        $query = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->select(
                'performance_reviews.id',
                'performance_reviews.employee_id',
                'performance_reviews.cycle_id',
                'performance_reviews.reviewer_id',
                'employees.display_name as employee',
                'job_titles.name as job_title',
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.status as review_status',
                'performance_reviews.overall_rating',
                'performance_reviews.comments'
            );

        // Apply filters
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('job_title')) {
            $query->where('job_titles.name', 'like', '%' . $request->input('job_title') . '%');
        }

        if ($request->filled('sub_unit')) {
            $query->where('organization_units.name', 'like', '%' . $request->input('sub_unit') . '%');
        }

        if ($request->filled('include')) {
            $include = $request->input('include');
            if ($include === 'current') {
                $query->whereNull('employees.deleted_at');
            } elseif ($include === 'past') {
                $query->whereNotNull('employees.deleted_at');
            }
            // 'all' doesn't need a filter
        } else {
            // Default to current employees only
            $query->whereNull('employees.deleted_at');
        }

        if ($request->filled('review_status')) {
            $query->where('performance_reviews.status', $request->input('review_status'));
        }

        if ($request->filled('reviewer')) {
            $query->where('reviewers.display_name', 'like', '%' . $request->input('reviewer') . '%');
        }

        if ($request->filled('from_date')) {
            $query->whereDate('performance_cycles.end_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('performance_cycles.end_date', '<=', $request->input('to_date'));
        }

        $reviews = $query->orderByDesc('performance_cycles.end_date')->get();

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

        $jobTitles = DB::table('job_titles')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        return view('performance.performance', compact('reviews', 'employees', 'cycles', 'jobTitles'));
    }

    public function storeReview(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'reviewer_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['required', 'string', 'in:not_started,in_progress,completed,approved'],
        ]);

        $reviewId = DB::table('performance_reviews')->insertGetId([
            'employee_id' => $data['employee_id'],
            'cycle_id' => $data['cycle_id'],
            'reviewer_id' => $data['reviewer_id'] ?? null,
            'status' => $data['status'],
            'overall_rating' => null,
            'comments' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Auto-create performance_review_kpis for all active KPIs
        $this->ratingService->createReviewKpis($reviewId);

        return redirect()->route('performance')
            ->with('status', 'Performance review added successfully.');
    }

    public function updateReview(Request $request, int $id)
    {
        // Get existing review data
        $review = DB::table('performance_reviews')->where('id', $id)->first();
        
        if (!$review) {
            return redirect()->route('performance')
                ->with('error', 'Review not found.');
        }

        $data = $request->validate([
            'overall_rating' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $updateData = [
            'updated_at' => now(),
        ];

        // Update overall_rating if provided, otherwise keep existing
        if (isset($data['overall_rating']) && $data['overall_rating'] !== null && $data['overall_rating'] !== '') {
            $updateData['overall_rating'] = (float) $data['overall_rating'];
        } else {
            // If empty, keep existing rating (don't update)
            $updateData['overall_rating'] = $review->overall_rating;
        }

        DB::table('performance_reviews')
            ->where('id', $id)
            ->update($updateData);

        return redirect()->route('performance')
            ->with('status', 'Overall rating updated successfully.');
    }

    public function viewReview(int $id)
    {
        $review = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->where('performance_reviews.id', $id)
            ->select(
                'employees.display_name as employee',
                'job_titles.name as job_title',
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.status',
                'performance_reviews.overall_rating',
                'performance_reviews.comments'
            )
            ->first();

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        return response()->json([
            'employee' => $review->employee,
            'job_title' => $review->job_title,
            'review_period' => $review->review_period,
            'due_date' => $review->due_date,
            'reviewer' => $review->reviewer,
            'status' => $review->status,
            'overall_rating' => $review->overall_rating,
            'comments' => $review->comments,
        ]);
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
        // MY TRACKERS = Reviews jahan current logged-in user reviewer (manager) hai
        $currentEmployeeId = $this->getCurrentEmployeeId();

        if (!$currentEmployeeId) {
            return redirect()->route('dashboard')
                ->with('error', 'Employee record not found. Please contact HR.');
        }

        $trackers = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->where('performance_reviews.reviewer_id', $currentEmployeeId) // Current user is the reviewer
            ->whereIn('performance_reviews.status', ['not_started', 'in_progress']) // Only pending reviews
            ->select(
                'performance_reviews.id',
                'performance_cycles.name as tracker',
                'performance_cycles.id as cycle_id',
                'performance_reviews.status',
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.reviewer_id',
                'performance_reviews.overall_rating',
                'employees.display_name as employee_name',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date")
            )
            ->orderByDesc('performance_reviews.created_at')
            ->get();

        return view('performance.my-trackers', compact('trackers'));
    }

    public function employeeTrackers(Request $request)
    {
        // EMPLOYEE TRACKERS = Manager ke pending reviews (jahan wo reviewer hai)
        $currentEmployeeId = $this->getCurrentEmployeeId();

        if (!$currentEmployeeId) {
            return redirect()->route('dashboard')
                ->with('error', 'Employee record not found. Please contact HR.');
        }

        // Get reviews where current user is the reviewer (only completed/approved - after form submission)
        $query = DB::table('performance_reviews')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->where('performance_reviews.reviewer_id', $currentEmployeeId) // Only reviews where current user is reviewer
            ->whereIn('performance_reviews.status', ['completed', 'approved']) // Only completed/approved reviews (after form submission)
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee_name',
                'employees.id as employee_id',
                'performance_cycles.name as tracker',
                'performance_cycles.id as cycle_id',
                'performance_reviews.status',
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.overall_rating',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date")
            );

        // Apply filters
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        // Date range filter: check both created_at (added_date) and updated_at (modified_date)
        // Show records if either added_date or modified_date falls within the date range
        if ($request->filled('from_date') || $request->filled('to_date')) {
            $fromDate = $request->input('from_date');
            $toDate = $request->input('to_date');
            
            $query->where(function($q) use ($fromDate, $toDate) {
                // Check if created_at (added_date) is in range
                $q->where(function($subQ) use ($fromDate, $toDate) {
                    if ($fromDate) {
                        $subQ->whereDate('performance_reviews.created_at', '>=', $fromDate);
                    }
                    if ($toDate) {
                        $subQ->whereDate('performance_reviews.created_at', '<=', $toDate);
                    }
                })
                // OR check if updated_at (modified_date) is in range
                ->orWhere(function($subQ) use ($fromDate, $toDate) {
                    if ($fromDate) {
                        $subQ->whereDate('performance_reviews.updated_at', '>=', $fromDate);
                    }
                    if ($toDate) {
                        $subQ->whereDate('performance_reviews.updated_at', '<=', $toDate);
                    }
                });
            });
        }

        $trackers = $query->orderBy('employees.display_name')->get();

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
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'employees.id as employee_id',
                'performance_cycles.id as cycle_id',
                'performance_cycles.name as tracker',
                DB::raw("DATE_FORMAT(performance_reviews.created_at, '%Y-%m-%d') as added_date"),
                DB::raw("DATE_FORMAT(performance_reviews.updated_at, '%Y-%m-%d') as modified_date"),
                'performance_reviews.status',
                'performance_reviews.reviewer_id',
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer"),
                'performance_reviews.overall_rating',
                'performance_reviews.comments'
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

        if ($request->filled('comments')) {
            $comments = $request->input('comments');
            $query->where('performance_reviews.comments', 'like', '%' . $comments . '%');
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

        // Get KPI ratings for each tracker
        foreach ($trackers as $tracker) {
            $tracker->kpis = $this->ratingService->getReviewKpis($tracker->id);
        }

        return view('performance.trackers', compact('trackers', 'employees', 'cycles'));
    }

    public function storeTracker(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'reviewer_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['nullable', 'string', 'in:not_started,in_progress,completed,approved'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        $reviewId = DB::table('performance_reviews')->insertGetId([
            'employee_id' => $data['employee_id'],
            'cycle_id' => $data['cycle_id'],
            'reviewer_id' => $data['reviewer_id'] ?? null,
            'status' => $data['status'] ?? 'not_started',
            'overall_rating' => null,
            'comments' => $data['comments'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Auto-create performance_review_kpis for all active KPIs
        $this->ratingService->createReviewKpis($reviewId);

        return redirect()->route('performance.trackers')
            ->with('status', 'Tracker added successfully.');
    }

    public function updateTracker(Request $request, int $id)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'cycle_id' => ['required', 'integer', 'exists:performance_cycles,id'],
            'reviewer_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['nullable', 'string', 'in:not_started,in_progress,completed,approved'],
            'comments' => ['nullable', 'string', 'max:2000'],
        ]);

        DB::table('performance_reviews')
            ->where('id', $id)
            ->update([
                'employee_id' => $data['employee_id'],
                'cycle_id' => $data['cycle_id'],
                'reviewer_id' => $data['reviewer_id'] ?? null,
                'status' => $data['status'] ?? 'not_started',
                'comments' => $data['comments'] ?? null,
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
        // MY REVIEWS = Employee ko sabhi reviews dikhane (all statuses)
        $employeeId = $this->getCurrentEmployeeId();

        if (!$employeeId) {
            return redirect()->route('dashboard')
                ->with('error', 'Employee record not found. Please contact HR.');
        }

        $reviews = DB::table('performance_reviews')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->where('performance_reviews.employee_id', $employeeId)
            ->select(
                'performance_reviews.id',
                'job_titles.name as job_title',
                DB::raw("COALESCE(organization_units.name, '-') as sub_unit"),
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                'performance_reviews.status as review_status',
                'performance_reviews.overall_rating',
                'performance_reviews.comments as feedback',
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer")
            )
            ->orderByDesc('performance_cycles.end_date')
            ->get();

        return view('performance.my-reviews', compact('reviews'));
    }

    public function employeeReviews(Request $request)
    {
        // EMPLOYEE REVIEWS = HR/Manager ko sab employees ke results (report view)
        $query = DB::table('performance_reviews')
            ->join('performance_cycles', 'performance_reviews.cycle_id', '=', 'performance_cycles.id')
            ->join('employees', 'performance_reviews.employee_id', '=', 'employees.id')
            ->join('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->leftJoin('employees as reviewers', 'performance_reviews.reviewer_id', '=', 'reviewers.id')
            ->select(
                'performance_reviews.id',
                'employees.display_name as employee',
                'job_titles.name as job_title',
                DB::raw("COALESCE(organization_units.name, '-') as sub_unit"),
                DB::raw("CONCAT(DATE_FORMAT(performance_cycles.start_date, '%Y-%m-%d'), ' - ', DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d')) as review_period"),
                DB::raw("DATE_FORMAT(performance_cycles.end_date, '%Y-%m-%d') as due_date"),
                'performance_reviews.status as review_status',
                'performance_reviews.overall_rating',
                'performance_reviews.comments as feedback',
                DB::raw("COALESCE(reviewers.display_name, '-') as reviewer")
            );

        // Apply filters
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->input('employee_name') . '%');
        }

        if ($request->filled('job_title')) {
            $query->where('job_titles.name', 'like', '%' . $request->input('job_title') . '%');
        }

        if ($request->filled('review_status')) {
            $query->where('performance_reviews.status', $request->input('review_status'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('performance_cycles.end_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('performance_cycles.end_date', '<=', $request->input('to_date'));
        }

        $reviews = $query->orderBy('employees.display_name')
            ->orderByDesc('performance_cycles.end_date')
            ->get();

        // Get distinct job titles for dropdown
        $jobTitles = DB::table('job_titles')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');

        return view('performance.employee-reviews', compact('reviews', 'jobTitles'));
    }

    /**
     * Get KPI ratings for a review
     */
    public function getReviewKpis(int $reviewId)
    {
        // Validate that review exists
        $review = DB::table('performance_reviews')->where('id', $reviewId)->first();
        if (!$review) {
            return response()->json(['error' => 'Review not found.'], 404);
        }

        // Ensure KPIs exist for this review (create if missing)
        $existingKpis = DB::table('performance_review_kpis')
            ->where('performance_review_id', $reviewId)
            ->count();
        
        if ($existingKpis == 0) {
            // Auto-create KPIs if they don't exist
            $this->ratingService->createReviewKpis($reviewId);
        }

        $kpis = $this->ratingService->getReviewKpis($reviewId);
        return response()->json($kpis);
    }

    /**
     * Save KPI ratings for a review
     */
    public function saveKpiRatings(Request $request, int $reviewId)
    {
        // Validate that review exists
        $review = DB::table('performance_reviews')->where('id', $reviewId)->first();
        if (!$review) {
            return redirect()->back()
                ->with('error', 'Review not found.');
        }

        // Ensure KPIs exist for this review (create if missing)
        $existingKpis = DB::table('performance_review_kpis')
            ->where('performance_review_id', $reviewId)
            ->count();
        
        if ($existingKpis == 0) {
            // Auto-create KPIs if they don't exist
            $this->ratingService->createReviewKpis($reviewId);
        }

        $data = $request->validate([
            'kpi_ratings' => ['nullable', 'array'],
            'kpi_ratings.*' => ['array'],
            'kpi_ratings.*.rating' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'kpi_ratings.*.comments' => ['nullable', 'string', 'max:1000'],
        ]);

        $ratings = [];
        if (isset($data['kpi_ratings']) && is_array($data['kpi_ratings'])) {
            foreach ($data['kpi_ratings'] as $kpiId => $ratingData) {
                if (is_array($ratingData)) {
                    $ratings[$kpiId] = [
                        'rating' => isset($ratingData['rating']) && $ratingData['rating'] !== '' ? (float) $ratingData['rating'] : null,
                        'comments' => $ratingData['comments'] ?? null,
                    ];
                }
            }
        }

        if (!empty($ratings)) {
            $this->ratingService->updateKpiRatings($reviewId, $ratings);
        }

        return redirect()->back()
            ->with('status', 'KPI ratings saved successfully.');
    }

    /**
     * Submit review - calculate overall rating
     */
    public function submitReview(Request $request, int $reviewId)
    {
        $data = $request->validate([
            'kpi_ratings' => ['nullable', 'array'],
            'kpi_ratings.*' => ['array'],
            'kpi_ratings.*.rating' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'kpi_ratings.*.comments' => ['nullable', 'string', 'max:1000'],
            'review_comments' => ['nullable', 'string', 'max:2000'],
        ]);

        // Save KPI ratings if provided
        if (isset($data['kpi_ratings']) && !empty($data['kpi_ratings'])) {
            $ratings = [];
            foreach ($data['kpi_ratings'] as $kpiId => $ratingData) {
                if (is_array($ratingData)) {
                    $ratings[$kpiId] = [
                        'rating' => isset($ratingData['rating']) && $ratingData['rating'] !== '' ? (float) $ratingData['rating'] : null,
                        'comments' => $ratingData['comments'] ?? null,
                    ];
                }
            }
            if (!empty($ratings)) {
                $this->ratingService->updateKpiRatings($reviewId, $ratings);
            }
        }

        // Calculate overall rating
        $overallRating = $this->ratingService->calculateOverallRating($reviewId);

        // Update review
        $updateData = [
            'overall_rating' => $overallRating,
            'status' => 'completed',
            'updated_at' => now(),
        ];

        if (isset($data['review_comments'])) {
            $updateData['comments'] = $data['review_comments'];
        }

        DB::table('performance_reviews')
            ->where('id', $reviewId)
            ->update($updateData);

        return redirect()->route('performance.employee-trackers')
            ->with('status', 'Review submitted successfully. Overall rating: ' . number_format($overallRating ?? 0, 2));
    }

    /**
     * Approve review
     */
    public function approveReview(int $reviewId)
    {
        DB::table('performance_reviews')
            ->where('id', $reviewId)
            ->update([
                'status' => 'approved',
                'updated_at' => now(),
            ]);

        return redirect()->back()
            ->with('status', 'Review approved successfully.');
    }
}

