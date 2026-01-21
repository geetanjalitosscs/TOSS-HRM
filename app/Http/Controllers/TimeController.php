<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function index()
    {
        $timesheets = [
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2026-05-01 - 2026-11-01'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2023-16-01 - 2023-22-01'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2022-15-08 - 2022-21-08'],
            ['employee_name' => 'manda akhil user', 'timesheet_period' => '2020-14-09 - 2020-20-09'],
        ];
        return view('time.index', compact('timesheets'));
    }
}

