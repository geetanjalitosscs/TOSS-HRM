<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RecruitmentController extends Controller
{
    public function index()
    {
        $candidates = [
            ['vacancy' => 'Senior QA Lead', 'candidate' => 'Tanmay Anderson O\'Keefe', 'hiring_manager' => 'manda akhil user', 'date' => '2024-29-03', 'status' => 'Shortlisted'],
            ['vacancy' => 'Payroll Administrator', 'candidate' => 'John Doe', 'hiring_manager' => 'manda akhil user', 'date' => '2024-06-02', 'status' => 'Rejected'],
            ['vacancy' => '', 'candidate' => 'Manu K M', 'hiring_manager' => '(Deleted)', 'date' => '2024-05-02', 'status' => 'Application initiated'],
            ['vacancy' => '', 'candidate' => 'madhav m', 'hiring_manager' => 'manda akhil user', 'date' => '2024-04-15', 'status' => 'Shortlisted'],
            ['vacancy' => 'Senior QA Lead', 'candidate' => 'Gautham Raj R', 'hiring_manager' => 'manda akhil user', 'date' => '2024-03-20', 'status' => 'Rejected'],
            ['vacancy' => '', 'candidate' => 'Cedric C Ross', 'hiring_manager' => '(Deleted)', 'date' => '2024-02-10', 'status' => 'Application initiated'],
            ['vacancy' => 'Payroll Administrator', 'candidate' => 'TestFN TestMN TestLN', 'hiring_manager' => 'manda akhil user', 'date' => '2024-01-25', 'status' => 'Shortlisted'],
            ['vacancy' => '', 'candidate' => 'AntoAnto 09:50 AM M Varghese', 'hiring_manager' => 'manda akhil user', 'date' => '2023-12-18', 'status' => 'Rejected'],
            ['vacancy' => 'Senior QA Lead', 'candidate' => 'Murali13s Krishna700 Veerfal', 'hiring_manager' => '(Deleted)', 'date' => '2023-11-05', 'status' => 'Application initiated'],
            ['vacancy' => '', 'candidate' => 'Manoj Regmi', 'hiring_manager' => 'manda akhil user', 'date' => '2023-10-12', 'status' => 'Shortlisted'],
        ];

        return view('recruitment.recruitment', compact('candidates'));
    }
}

