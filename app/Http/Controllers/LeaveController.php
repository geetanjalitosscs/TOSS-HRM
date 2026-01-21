<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        // Sample leave data (empty for now as shown in image)
        $leaves = [];

        return view('leave.index', compact('leaves'));
    }
}

