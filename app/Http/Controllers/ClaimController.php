<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        // Sample employee claims data
        $claims = [
            [
                'reference_id' => '202307180000003',
                'employee_name' => 'manda user',
                'event_name' => 'Travel Allowance',
                'description' => '',
                'currency' => 'Algerian Dinar',
                'submitted_date' => '2023-18-07',
                'status' => 'Submitted',
                'amount' => '7,300.32'
            ],
            [
                'reference_id' => '202307180000002',
                'employee_name' => 'manda user',
                'event_name' => 'Medical Reimbursement',
                'description' => '',
                'currency' => 'Canadian Dollar',
                'submitted_date' => '2023-18-07',
                'status' => 'Submitted',
                'amount' => '1,250.12'
            ],
            [
                'reference_id' => '202307180000001',
                'employee_name' => 'manda user',
                'event_name' => 'Accommodation',
                'description' => '',
                'currency' => 'Afghanistan Afghani',
                'submitted_date' => '2023-18-07',
                'status' => 'Initiated',
                'amount' => '0.00'
            ],
        ];

        return view('claim.claim', compact('claims'));
    }
}

