<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PIMController extends Controller
{
    public function index()
    {
        return redirect()->route('pim.employee-list');
    }

    public function employeeList()
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

        return view('pim.employee-list', compact('employees'));
    }

    public function addEmployee()
    {
        return view('pim.add-employee');
    }

    public function reports()
    {
        $reports = [
            ['id' => 1, 'name' => 'All Employee Sub Unit Hierarchy Report'],
            ['id' => 2, 'name' => 'Employee Contact info report'],
            ['id' => 3, 'name' => 'PIM Sample Report'],
        ];
        return view('pim.reports', compact('reports'));
    }

    // Configuration methods
    public function optionalFields()
    {
        return view('pim.configuration.optional-fields');
    }

    public function customFields()
    {
        $customFields = [
            ['id' => 1, 'name' => 'Blood Type', 'screen' => 'Personal Details', 'field_type' => 'Drop Down'],
            ['id' => 2, 'name' => 'Test_Field', 'screen' => 'Personal Details', 'field_type' => 'Text or Number'],
        ];
        return view('pim.configuration.custom-fields', compact('customFields'));
    }

    public function dataImport()
    {
        return view('pim.configuration.data-import');
    }

    public function reportingMethods()
    {
        $reportingMethods = [
            ['id' => 1, 'name' => 'Annual Report'],
            ['id' => 2, 'name' => 'Direct'],
            ['id' => 3, 'name' => 'Indirect'],
            ['id' => 4, 'name' => 'Test_Reporting'],
        ];
        return view('pim.configuration.reporting-methods', compact('reportingMethods'));
    }

    public function terminationReasons()
    {
        $terminationReasons = [
            ['id' => 1, 'name' => 'Attendance Issue'],
            ['id' => 2, 'name' => 'Contract Not Renewed'],
            ['id' => 3, 'name' => 'Deceased'],
            ['id' => 4, 'name' => 'Dismissed'],
            ['id' => 5, 'name' => 'fever'],
            ['id' => 6, 'name' => 'Laid-off'],
            ['id' => 7, 'name' => 'Other'],
            ['id' => 8, 'name' => 'Physically Disabled/Compensated'],
            ['id' => 9, 'name' => 'Resigned'],
            ['id' => 10, 'name' => 'Resigned - Company Requested'],
            ['id' => 11, 'name' => 'Resigned - Self Proposed'],
            ['id' => 12, 'name' => 'Retired'],
            ['id' => 13, 'name' => 'Test_Termination'],
        ];
        return view('pim.configuration.termination-reasons', compact('terminationReasons'));
    }
}

