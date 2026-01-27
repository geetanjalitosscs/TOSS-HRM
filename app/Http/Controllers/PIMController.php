<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PIMController extends Controller
{
    public function index()
    {
        return redirect()->route('pim.employee-list');
    }

    public function employeeList()
    {
        $employees = DB::table('employees')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('employment_statuses', 'employees.employment_status_id', '=', 'employment_statuses.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->leftJoin('employees as supervisors', 'employees.supervisor_id', '=', 'supervisors.id')
            ->select(
                'employees.id',
                'employees.employee_number as employee_number',
                'employees.first_name',
                'employees.last_name',
                'job_titles.name as job_title',
                'employment_statuses.name as employment_status',
                'organization_units.name as sub_unit',
                DB::raw("COALESCE(supervisors.display_name, '') as supervisor")
            )
            ->orderBy('employees.employee_number')
            ->get();

        return view('pim.employee-list', compact('employees'));
    }

    public function addEmployee()
    {
        return view('pim.add-employee');
    }

    public function reports()
    {
        $reports = DB::table('employee_qualifications')
            ->join('employees', 'employee_qualifications.employee_id', '=', 'employees.id')
            ->join('qualifications', 'employee_qualifications.qualification_id', '=', 'qualifications.id')
            ->select(
                DB::raw('DISTINCT qualifications.name as name')
            )
            ->orderBy('name')
            ->get();

        return view('pim.reports', compact('reports'));
    }

    // Configuration methods
    public function optionalFields()
    {
        return view('pim.configuration.optional-fields');
    }

    public function customFields()
    {
        $customFields = DB::table('custom_fields')
            ->select('id', 'name', 'module as screen', 'data_type as field_type')
            ->orderBy('name')
            ->get();
        return view('pim.configuration.custom-fields', compact('customFields'));
    }

    public function dataImport()
    {
        return view('pim.configuration.data-import');
    }

    public function reportingMethods()
    {
        $reportingMethods = DB::table('reporting_methods')
            ->select('id', 'name')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();
        return view('pim.configuration.reporting-methods', compact('reportingMethods'));
    }

    public function terminationReasons()
    {
        $terminationReasons = DB::table('termination_reasons')
            ->select('id', 'name')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();
        return view('pim.configuration.termination-reasons', compact('terminationReasons'));
    }
}

