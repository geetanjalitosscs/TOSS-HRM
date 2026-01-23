<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        return redirect()->route('leave.leave-list');
    }

    public function apply()
    {
        return view('leave.apply');
    }

    public function myLeave()
    {
        $leaves = [];
        return view('leave.my-leave', compact('leaves'));
    }

    public function leaveList()
    {
        $leaves = [];
        return view('leave.leave-list', compact('leaves'));
    }

    public function assignLeave()
    {
        return view('leave.assign-leave');
    }

    // Entitlements
    public function addEntitlement()
    {
        return view('leave.add-entitlement');
    }

    public function myEntitlements()
    {
        $entitlements = [];
        return view('leave.my-entitlements', compact('entitlements'));
    }

    public function employeeEntitlements()
    {
        return view('leave.employee-entitlements');
    }

    // Reports
    public function entitlementsUsageReport()
    {
        return view('leave.entitlements-usage-report');
    }

    public function myEntitlementsUsageReport()
    {
        $reportData = [];
        return view('leave.my-entitlements-usage-report', compact('reportData'));
    }

    // Configure
    public function leaveTypes()
    {
        $leaveTypes = [];
        return view('leave.leave-types', compact('leaveTypes'));
    }

    public function leavePeriod()
    {
        return view('leave.leave-period');
    }

    public function workWeek()
    {
        return view('leave.work-week');
    }

    public function holidays()
    {
        $holidays = [];
        return view('leave.holidays', compact('holidays'));
    }
}

