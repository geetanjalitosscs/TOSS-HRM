<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecruitmentController extends Controller
{
    public function index()
    {
        $candidates = DB::table('candidate_applications')
            ->join('candidates', 'candidate_applications.candidate_id', '=', 'candidates.id')
            ->join('vacancies', 'candidate_applications.vacancy_id', '=', 'vacancies.id')
            ->leftJoin('employees as managers', 'vacancies.hiring_manager_id', '=', 'managers.id')
            ->select(
                'candidate_applications.id',
                'vacancies.name as vacancy',
                DB::raw("CONCAT(candidates.first_name, ' ', COALESCE(candidates.last_name, '')) as candidate"),
                DB::raw("COALESCE(managers.display_name, '(Deleted)') as hiring_manager"),
                DB::raw("DATE_FORMAT(candidate_applications.applied_date, '%Y-%m-%d') as date"),
                DB::raw("CASE
                    WHEN candidate_applications.status = 'shortlisted' THEN 'Shortlisted'
                    WHEN candidate_applications.status = 'rejected' THEN 'Rejected'
                    ELSE 'Application initiated'
                END as status")
            )
            ->orderByDesc('candidate_applications.applied_date')
            ->get();

        return view('recruitment.recruitment', compact('candidates'));
    }

    public function vacancies()
    {
        $vacancies = DB::table('vacancies')
            ->join('job_titles', 'vacancies.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employees as managers', 'vacancies.hiring_manager_id', '=', 'managers.id')
            ->select(
                'vacancies.id',
                'vacancies.name as vacancy',
                'job_titles.name as job_title',
                DB::raw("COALESCE(managers.display_name, '(Deleted)') as hiring_manager"),
                DB::raw("CASE
                    WHEN vacancies.status = 'open' THEN 'Active'
                    WHEN vacancies.status = 'on_hold' THEN 'On Hold'
                    ELSE 'Closed'
                END as status")
            )
            ->orderBy('vacancies.name')
            ->get();

        return view('recruitment.vacancies', compact('vacancies'));
    }
}

