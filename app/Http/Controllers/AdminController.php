<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
            ->leftJoin('user_roles', 'users.id', '=', 'user_roles.user_id')
            ->leftJoin('roles', 'user_roles.role_id', '=', 'roles.id')
            ->leftJoin('employees', 'users.employee_id', '=', 'employees.id')
            ->select(
                'users.id',
                'users.username',
                DB::raw("COALESCE(roles.name, 'ESS') as role"),
                DB::raw("COALESCE(employees.display_name, '') as employee_name"),
                DB::raw("CASE WHEN users.is_active = 1 THEN 'Enabled' ELSE 'Disabled' END as status")
            )
            ->get();

        return view('admin.admin', compact('users'));
    }

    public function jobTitles()
    {
        $jobTitles = DB::table('job_titles')
            ->select('id', 'name as title', 'description')
            ->orderBy('name')
            ->get();
        return view('admin.job.job-titles', compact('jobTitles'));
    }

    public function payGrades()
    {
        $payGrades = DB::table('pay_grades')
            ->select('id', 'name', 'currency')
            ->orderBy('name')
            ->get();
        return view('admin.job.pay-grades', compact('payGrades'));
    }

    public function employmentStatus()
    {
        $statuses = DB::table('employment_statuses')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.job.employment-status', compact('statuses'));
    }

    public function jobCategories()
    {
        $categories = DB::table('job_categories')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.job.job-categories', compact('categories'));
    }

    public function workShifts()
    {
        $shifts = DB::table('work_shifts')
            ->select(
                'id',
                'name',
                DB::raw("DATE_FORMAT(start_time, '%h:%i %p') as start_time_formatted"),
                DB::raw("DATE_FORMAT(end_time, '%h:%i %p') as end_time_formatted"),
                'hours_per_day as hours'
            )
            ->orderBy('name')
            ->get();
        return view('admin.job.work-shifts', compact('shifts'));
    }

    public function organizationGeneral()
    {
        // Get organization data from database (assuming first organization or default)
        $organization = DB::table('organizations')->first();
        
        // Get employee count
        $employeeCount = DB::table('employees')->where('status', 'active')->count();
        
        return view('admin.organization.general-information', compact('organization', 'employeeCount'));
    }

    public function organizationLocations()
    {
        $locations = DB::table('locations')
            ->leftJoin('employees', 'locations.id', '=', 'employees.location_id')
            ->select(
                'locations.id',
                'locations.name',
                'locations.city',
                'locations.country',
                'locations.phone',
                DB::raw('COUNT(employees.id) as num_employees')
            )
            ->groupBy('locations.id', 'locations.name', 'locations.city', 'locations.country', 'locations.phone')
            ->orderBy('locations.name')
            ->get();
        return view('admin.organization.locations', compact('locations'));
    }

    public function organizationStructure()
    {
        return view('admin.organization.structure');
    }

    public function qualificationsSkills()
    {
        $skills = DB::table('qualifications')
            ->where('type', 'skill')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.skills', compact('skills'));
    }

    public function qualificationsEducation()
    {
        $education = DB::table('qualifications')
            ->where('type', 'education')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.education', compact('education'));
    }

    public function qualificationsLicenses()
    {
        $licenses = DB::table('qualifications')
            ->where('type', 'certification')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.licenses', compact('licenses'));
    }

    public function qualificationsLanguages()
    {
        $languages = DB::table('qualifications')
            ->where('type', 'language')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.languages', compact('languages'));
    }

    public function qualificationsMemberships()
    {
        $memberships = DB::table('qualifications')
            ->where('type', 'other')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.qualifications.memberships', compact('memberships'));
    }

    public function nationalities()
    {
        $nationalities = DB::table('nationalities')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('admin.nationalities', compact('nationalities'));
    }

    public function corporateBranding()
    {
        return view('admin.corporate-branding');
    }

    // Configuration methods
    public function emailConfiguration()
    {
        return view('admin.configuration.email-configuration');
    }

    public function emailSubscriptions()
    {
        $subscriptions = DB::table('email_subscriptions')
            ->select('id', 'name as notification_type')
            ->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->subscribers = '';
                return $row;
            });
        return view('admin.configuration.email-subscriptions', compact('subscriptions'));
    }

    public function localization()
    {
        return view('admin.configuration.localization');
    }

    public function languagePackages()
    {
        $languages = DB::table('language_packages')
            ->select('id', 'name', DB::raw("name as native"))
            ->orderBy('sort_order')
            ->get();
        return view('admin.configuration.language-packages', compact('languages'));
    }

    public function moduleConfiguration()
    {
        $labelMap = [
            'admin'       => 'Admin Module',
            'pim'         => 'Pim Module',
            'leave'       => 'Leave Module',
            'time'        => 'Time Module',
            'recruitment' => 'Recruitment Module',
            'performance' => 'Performance Module',
            'directory'   => 'Directory Module',
            'maintenance' => 'Maintenance Module',
            'mobile'      => 'Mobile',
            'claim'       => 'Claim Module',
            'buzz'        => 'Buzz',
        ];

        $modules = DB::table('enabled_modules')
            ->select('id', 'module_key', 'is_enabled')
            ->orderBy('module_key')
            ->get()
            ->map(function ($row) use ($labelMap) {
                $row->name = $labelMap[$row->module_key] ?? ucfirst($row->module_key) . ' Module';
                $row->enabled = (bool)$row->is_enabled;
                return $row;
            });
        return view('admin.configuration.module-configuration', compact('modules'));
    }

    public function socialMediaAuthentication()
    {
        $providers = DB::table('social_providers')
            ->select('id', 'name', 'is_active')
            ->orderBy('name')
            ->get();
        return view('admin.configuration.social-media-authentication', compact('providers'));
    }

    public function oauthClientList()
    {
        $oauthClients = DB::table('oauth_clients')
            ->select('id', 'name', 'redirect_uri', 'is_active')
            ->orderBy('name')
            ->get()
            ->map(function ($row) {
                $row->status = $row->is_active ? 'Enabled' : 'Disabled';
                return $row;
            });
        return view('admin.configuration.oauth-client-list', compact('oauthClients'));
    }

    public function ldapConfiguration()
    {
        return view('admin.configuration.ldap-configuration');
    }
}

