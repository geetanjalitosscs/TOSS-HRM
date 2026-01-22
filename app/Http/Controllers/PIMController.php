<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PIMController extends Controller
{
    public function index()
    {
        // Sample employee data
        $employees = [
            ['id' => '0295', 'first_name' => '99N75426', 'last_name' => 'STIV', 'job_title' => 'Automation Tester', 'employment_status' => 'Full-Time Contract', 'sub_unit' => 'Engineering', 'supervisor' => ''],
            ['id' => '04562214', 'first_name' => 'Abhay kumar', 'last_name' => 'Kasuhik', 'job_title' => '', 'employment_status' => '', 'sub_unit' => '', 'supervisor' => ''],
            ['id' => '04272214', 'first_name' => 'Abhay kumar', 'last_name' => 'Kasuhik', 'job_title' => '', 'employment_status' => '', 'sub_unit' => '', 'supervisor' => ''],
            ['id' => '001', 'first_name' => 'ATPValue', 'last_name' => 'Test', 'job_title' => 'Software Engineer', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Engineering', 'supervisor' => 'John Doe'],
            ['id' => '002', 'first_name' => 'ATPValue', 'last_name' => 'Sample', 'job_title' => 'QA Engineer', 'employment_status' => 'Part-Time Contract', 'sub_unit' => 'Quality Assurance', 'supervisor' => 'Jane Smith'],
            ['id' => '003', 'first_name' => 'Raman', 'last_name' => 'Sharma', 'job_title' => 'HR Manager', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Human Resources', 'supervisor' => ''],
            ['id' => '004', 'first_name' => 'Priya', 'last_name' => 'Patel', 'job_title' => 'Business Analyst', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Business Development', 'supervisor' => 'Mike Johnson'],
            ['id' => '005', 'first_name' => 'Amit', 'last_name' => 'Kumar', 'job_title' => 'DevOps Engineer', 'employment_status' => 'Full-Time Contract', 'sub_unit' => 'Engineering', 'supervisor' => 'Sarah Williams'],
            ['id' => '006', 'first_name' => 'Sneha', 'last_name' => 'Reddy', 'job_title' => 'UI/UX Designer', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Design', 'supervisor' => 'David Brown'],
            ['id' => '007', 'first_name' => 'Vikram', 'last_name' => 'Singh', 'job_title' => 'Project Manager', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Management', 'supervisor' => ''],
            ['id' => '008', 'first_name' => 'Anjali', 'last_name' => 'Mehta', 'job_title' => 'Data Analyst', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Analytics', 'supervisor' => 'Robert Taylor'],
            ['id' => '009', 'first_name' => 'Rajesh', 'last_name' => 'Verma', 'job_title' => 'Backend Developer', 'employment_status' => 'Full-Time Contract', 'sub_unit' => 'Engineering', 'supervisor' => 'Emily Davis'],
            ['id' => '010', 'first_name' => 'Kavita', 'last_name' => 'Nair', 'job_title' => 'Frontend Developer', 'employment_status' => 'Full-Time Permanent', 'sub_unit' => 'Engineering', 'supervisor' => 'Chris Anderson'],
        ];

        return view('pim.pim', compact('employees'));
    }
}

