<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        // Sample data for Manage Performance Reviews
        $reviews = [
            [
                'employee' => 'testuser k',
                'job_title' => 'Automaton Tester',
                'review_period' => '2026-25-01 - 2026-09-03',
                'due_date' => '2026-14-04',
                'reviewer' => 'testuser2 k',
                'review_status' => 'Activated',
            ]
        ];

        return view('performance.performance', compact('reviews'));
    }

    public function myTrackers()
    {
        // Sample data for My Performance Trackers
        $trackers = [
            [
                'tracker' => 'Tracker for paul',
                'added_date' => '2022-04-08',
                'modified_date' => '',
            ]
        ];

        return view('performance.my-trackers', compact('trackers'));
    }

    public function employeeTrackers()
    {
        // Sample data for Employee Performance Trackers
        $trackers = [
            [
                'employee_name' => 'Deepak Barne',
                'tracker' => 'Tracker for paul',
                'added_date' => '2022-04-08',
                'modified_date' => '',
            ]
        ];

        return view('performance.employee-trackers', compact('trackers'));
    }

    public function kpis()
    {
        // Sample data for KPIs
        $kpis = [
            [
                'kpi' => 'Assess information to develop strategies',
                'job_title' => 'Payroll Administrator',
                'min_rate' => '0',
                'max_rate' => '100',
                'is_default' => 'No',
            ],
            [
                'kpi' => 'Authored Tests',
                'job_title' => 'QA Lead',
                'min_rate' => '0',
                'max_rate' => '100',
                'is_default' => 'No',
            ],
            [
                'kpi' => 'Formal management of staff performance and responsibilities',
                'job_title' => 'HR Manager',
                'min_rate' => '0',
                'max_rate' => '100',
                'is_default' => 'Yes',
            ],
        ];

        return view('performance.kpis', compact('kpis'));
    }

    public function trackers()
    {
        // Sample data for Performance Trackers
        $trackers = [
            [
                'employee' => 'John Doe',
                'tracker' => 'Tracker for paul',
                'added_date' => '2022-04-08',
                'modified_date' => '',
            ]
        ];

        return view('performance.trackers', compact('trackers'));
    }

    public function myReviews()
    {
        // Sample data for My Reviews
        $reviews = [
            [
                'job_title' => 'HR Manager',
                'sub_unit' => 'Human Resources',
                'review_period' => '2022-01-07 - 2022-30-12',
                'due_date' => '2022-31-12',
                'self_evaluation_status' => 'Activated',
                'review_status' => 'Activated',
            ]
        ];

        return view('performance.my-reviews', compact('reviews'));
    }

    public function employeeReviews()
    {
        // Empty array for "No Records Found" state
        $reviews = [];

        return view('performance.employee-reviews', compact('reviews'));
    }
}

