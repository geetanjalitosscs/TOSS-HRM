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
}

