<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index()
    {
        // Empty array for "No Records Found" state
        $reviews = [];

        return view('performance.index', compact('reviews'));
    }
}

