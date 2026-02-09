<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecruitmentController extends Controller
{
    public function index(Request $request)
    {
        // Get dropdown options
        $vacancies = DB::table('vacancies')
            ->whereNull('deleted_at')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $employees = DB::table('employees')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as display_name"))
            ->orderBy('display_name')
            ->get();

        // Build query with search filters
        $query = DB::table('candidate_applications')
            ->join('candidates', 'candidate_applications.candidate_id', '=', 'candidates.id')
            ->join('vacancies', 'candidate_applications.vacancy_id', '=', 'vacancies.id')
            ->leftJoin('job_titles', 'vacancies.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employees as managers', 'vacancies.hiring_manager_id', '=', 'managers.id')
            ->select(
                'candidate_applications.id',
                'candidate_applications.vacancy_id',
                'vacancies.name as vacancy',
                'vacancies.job_title_id',
                'vacancies.hiring_manager_id',
                DB::raw("CONCAT(candidates.first_name, ' ', COALESCE(candidates.last_name, '')) as candidate"),
                DB::raw("COALESCE(managers.display_name, '(Deleted)') as hiring_manager"),
                DB::raw("DATE_FORMAT(candidate_applications.applied_date, '%Y-%m-%d') as date"),
                'candidate_applications.status',
                DB::raw("CASE
                    WHEN candidate_applications.status = 'new' THEN 'Application Initiated'
                    WHEN candidate_applications.status = 'shortlisted' THEN 'Shortlisted'
                    WHEN candidate_applications.status = 'interview_scheduled' THEN 'Interview Scheduled'
                    WHEN candidate_applications.status = 'offered' THEN 'Offered'
                    WHEN candidate_applications.status = 'rejected' THEN 'Rejected'
                    WHEN candidate_applications.status = 'hired' THEN 'Hired'
                    ELSE 'Application Initiated'
                END as status_display")
            );

        // Apply search filters
        if ($request->filled('vacancy')) {
            $query->where('vacancies.id', $request->input('vacancy'));
        }

        if ($request->filled('candidate_name')) {
            $candidateName = $request->input('candidate_name');
            $query->where(function($q) use ($candidateName) {
                $q->where('candidates.first_name', 'like', "%{$candidateName}%")
                  ->orWhere('candidates.last_name', 'like', "%{$candidateName}%");
            });
        }

        if ($request->filled('hiring_manager')) {
            $query->where('vacancies.hiring_manager_id', $request->input('hiring_manager'));
        }

        if ($request->filled('status')) {
            $query->where('candidate_applications.status', $request->input('status'));
        }

        if ($request->filled('job_title')) {
            $query->where('vacancies.job_title_id', $request->input('job_title'));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('candidate_applications.applied_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('candidate_applications.applied_date', '<=', $request->input('to_date'));
        }

        $candidates = $query->orderByDesc('candidate_applications.applied_date')->get();

        return view('recruitment.recruitment', compact('candidates', 'vacancies', 'jobTitles', 'employees'));
    }

    public function storeCandidate(Request $request)
    {
        $data = $request->validate([
            'vacancy_id' => ['required', 'integer', 'exists:vacancies,id'],
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['nullable', 'email', 'max:191'],
            'status' => ['required', 'string', 'in:new,shortlisted,interview_scheduled,offered,rejected,hired'],
        ]);

        $candidateId = DB::table('candidates')->insertGetId([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'] ?? null,
            'email' => $data['email'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('candidate_applications')->insert([
            'candidate_id' => $candidateId,
            'vacancy_id' => $data['vacancy_id'],
            'status' => $data['status'],
            'applied_date' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('recruitment')
            ->with('status', 'Candidate application added successfully.');
    }

    public function updateCandidate(Request $request, int $id)
    {
        $data = $request->validate([
            'vacancy_id' => ['required', 'integer', 'exists:vacancies,id'],
            'candidate_name' => ['required', 'string', 'max:200'],
            'status' => ['required', 'string', 'in:new,shortlisted,interview_scheduled,offered,rejected,hired'],
        ]);

        $application = DB::table('candidate_applications')->where('id', $id)->first();
        if (!$application) {
            return redirect()->route('recruitment')
                ->with('error', 'Candidate application not found.');
        }

        $nameParts = explode(' ', $data['candidate_name'], 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : null;

        DB::table('candidates')
            ->where('id', $application->candidate_id)
            ->update([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'updated_at' => now(),
            ]);

        DB::table('candidate_applications')
            ->where('id', $id)
            ->update([
                'vacancy_id' => $data['vacancy_id'],
                'status' => $data['status'],
                'updated_at' => now(),
            ]);

        return redirect()->route('recruitment')
            ->with('status', 'Candidate application updated successfully.');
    }

    public function deleteCandidate(int $id)
    {
        $application = DB::table('candidate_applications')->where('id', $id)->first();
        if ($application) {
            DB::table('candidate_applications')->where('id', $id)->delete();
            DB::table('candidates')->where('id', $application->candidate_id)->delete();
        }

        return redirect()->route('recruitment')
            ->with('status', 'Candidate application deleted successfully.');
    }

    public function bulkDeleteCandidates(Request $request)
    {
        $ids = explode(',', $request->input('ids', ''));
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return redirect()->route('recruitment')
                ->with('error', 'No candidates selected for deletion.');
        }

        $applications = DB::table('candidate_applications')->whereIn('id', $ids)->get();
        $candidateIds = $applications->pluck('candidate_id')->unique();

        DB::table('candidate_applications')->whereIn('id', $ids)->delete();
        DB::table('candidates')->whereIn('id', $candidateIds)->delete();

        return redirect()->route('recruitment')
            ->with('status', count($ids) . ' candidate application(s) deleted successfully.');
    }

    public function vacancies(Request $request)
    {
        // Get dropdown options
        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();
        $employees = DB::table('employees')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as display_name"))
            ->orderBy('display_name')
            ->get();

        // Build query with search filters
        $query = DB::table('vacancies')
            ->join('job_titles', 'vacancies.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employees as managers', 'vacancies.hiring_manager_id', '=', 'managers.id')
            ->select(
                'vacancies.id',
                'vacancies.name as vacancy',
                'vacancies.job_title_id',
                'vacancies.hiring_manager_id',
                'vacancies.status',
                'job_titles.name as job_title',
                DB::raw("COALESCE(managers.display_name, '(Deleted)') as hiring_manager"),
                DB::raw("CASE
                    WHEN vacancies.status = 'open' THEN 'Active'
                    WHEN vacancies.status = 'on_hold' THEN 'On Hold'
                    ELSE 'Closed'
                END as status_display")
            );

        // Apply search filters
        if ($request->filled('job_title')) {
            $query->where('vacancies.job_title_id', $request->input('job_title'));
        }

        if ($request->filled('vacancy')) {
            $vacancyName = $request->input('vacancy');
            $query->where('vacancies.name', 'like', "%{$vacancyName}%");
        }

        if ($request->filled('hiring_manager')) {
            $query->where('vacancies.hiring_manager_id', $request->input('hiring_manager'));
        }

        if ($request->filled('status')) {
            $query->where('vacancies.status', $request->input('status'));
        }

        $vacancies = $query->orderBy('vacancies.name')->get();

        return view('recruitment.vacancies', compact('vacancies', 'jobTitles', 'employees'));
    }

    public function storeVacancy(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'job_title_id' => ['required', 'integer', 'exists:job_titles,id'],
            'hiring_manager_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['required', 'string', 'in:open,on_hold,closed'],
        ]);

        DB::table('vacancies')->insert([
            'name' => $data['name'],
            'job_title_id' => $data['job_title_id'],
            'hiring_manager_id' => $data['hiring_manager_id'] ?? null,
            'status' => $data['status'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('recruitment.vacancies')
            ->with('status', 'Vacancy added successfully.');
    }

    public function updateVacancy(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'job_title_id' => ['required', 'integer', 'exists:job_titles,id'],
            'hiring_manager_id' => ['nullable', 'integer', 'exists:employees,id'],
            'status' => ['required', 'string', 'in:open,on_hold,closed'],
        ]);

        $vacancy = DB::table('vacancies')->where('id', $id)->first();
        if (!$vacancy) {
            return redirect()->route('recruitment.vacancies')
                ->with('error', 'Vacancy not found.');
        }

        DB::table('vacancies')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'job_title_id' => $data['job_title_id'],
                'hiring_manager_id' => $data['hiring_manager_id'] ?? null,
                'status' => $data['status'],
                'updated_at' => now(),
            ]);

        return redirect()->route('recruitment.vacancies')
            ->with('status', 'Vacancy updated successfully.');
    }

    public function deleteVacancy(int $id)
    {
        $vacancy = DB::table('vacancies')->where('id', $id)->first();
        if ($vacancy) {
            DB::table('vacancies')->where('id', $id)->delete();
        }

        return redirect()->route('recruitment.vacancies')
            ->with('status', 'Vacancy deleted successfully.');
    }

    public function bulkDeleteVacancies(Request $request)
    {
        $ids = explode(',', $request->input('ids', ''));
        $ids = array_filter(array_map('intval', $ids));

        if (empty($ids)) {
            return redirect()->route('recruitment.vacancies')
                ->with('error', 'No vacancies selected for deletion.');
        }

        DB::table('vacancies')->whereIn('id', $ids)->delete();

        return redirect()->route('recruitment.vacancies')
            ->with('status', count($ids) . ' vacancy(ies) deleted successfully.');
    }
}

