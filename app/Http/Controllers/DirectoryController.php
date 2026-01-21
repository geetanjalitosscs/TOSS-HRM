<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DirectoryController extends Controller
{
    public function index()
    {
        // Sample employee directory data
        $employees = [
            ['id' => '001', 'name' => 'Peter Mac Anderson', 'job_title' => 'Chief Financial Officer', 'department' => 'Administration', 'has_photo' => true],
            ['id' => '002', 'name' => 'vv6IU 72eK1', 'job_title' => '', 'department' => '', 'has_photo' => false],
            ['id' => '003', 'name' => 'yedghjb1 ru84 90jsnd', 'job_title' => '', 'department' => '', 'has_photo' => false],
            ['id' => '004', 'name' => 'Ranga Akunuri', 'job_title' => 'Software Engineer', 'department' => 'Engineering', 'has_photo' => false],
            ['id' => '005', 'name' => 'Timothy Lewis Amiano', 'job_title' => 'QA Engineer', 'department' => 'Quality Assurance', 'has_photo' => false],
            ['id' => '006', 'name' => 'Ravi M B', 'job_title' => 'HR Manager', 'department' => 'Human Resources', 'has_photo' => false],
            ['id' => '007', 'name' => 'Thomas Kutty Benny', 'job_title' => 'Business Analyst', 'department' => 'Business Development', 'has_photo' => false],
            ['id' => '008', 'name' => 'bla bla blablabla', 'job_title' => '', 'department' => '', 'has_photo' => false],
            ['id' => '009', 'name' => 'John Doe', 'job_title' => 'Project Manager', 'department' => 'Management', 'has_photo' => false],
            ['id' => '010', 'name' => 'Jane Smith', 'job_title' => 'UI/UX Designer', 'department' => 'Design', 'has_photo' => false],
            ['id' => '011', 'name' => 'Mike Johnson', 'job_title' => 'DevOps Engineer', 'department' => 'Engineering', 'has_photo' => false],
            ['id' => '012', 'name' => 'Sarah Williams', 'job_title' => 'Data Analyst', 'department' => 'Analytics', 'has_photo' => false],
            ['id' => '013', 'name' => 'David Brown', 'job_title' => 'Marketing Manager', 'department' => 'Marketing', 'has_photo' => false],
            ['id' => '014', 'name' => 'Emily Davis', 'job_title' => 'Sales Executive', 'department' => 'Sales', 'has_photo' => false],
            ['id' => '015', 'name' => 'Robert Wilson', 'job_title' => 'Network Administrator', 'department' => 'IT', 'has_photo' => false],
            ['id' => '016', 'name' => 'Lisa Anderson', 'job_title' => 'Accountant', 'department' => 'Finance', 'has_photo' => false],
            ['id' => '017', 'name' => 'Michael Taylor', 'job_title' => 'Content Writer', 'department' => 'Content', 'has_photo' => false],
            ['id' => '018', 'name' => 'Jennifer Martinez', 'job_title' => 'Customer Support', 'department' => 'Support', 'has_photo' => false],
        ];

        return view('directory.index', compact('employees'));
    }
}

