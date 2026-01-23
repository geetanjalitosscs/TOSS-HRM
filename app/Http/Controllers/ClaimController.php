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

    public function submit()
    {
        // Sample dropdown options (static prototype data)
        $events = [
            'Travel Allowance',
            'Medical Reimbursement',
            'Accommodation',
            'Meal Allowance',
        ];

        $currencies = [
            'Afghanistan Afghani',
            'Algerian Dinar',
            'Argentine Peso',
            'Australian Dollar',
            'Bangladeshi Taka',
            'Brazilian Real',
            'Canadian Dollar',
            'Chinese Yuan',
            'Danish Krone',
            'US Dollar',
            'Euro',
            'British Pound',
            'Hong Kong Dollar',
            'Indian Rupee',
            'Indonesian Rupiah',
            'Japanese Yen',
            'Malaysian Ringgit',
            'Mexican Peso',
            'New Zealand Dollar',
            'Norwegian Krone',
            'Pakistani Rupee',
            'Philippine Peso',
            'Saudi Riyal',
            'Singapore Dollar',
            'South African Rand',
            'South Korean Won',
            'Sri Lankan Rupee',
            'Swedish Krona',
            'Swiss Franc',
            'Thai Baht',
            'Turkish Lira',
            'UAE Dirham',
        ];

        return view('claim.submit-claim', compact('events', 'currencies'));
    }

    public function myClaims()
    {
        // Sample claims data for "My Claims" (static prototype data)
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

        $events = [
            'Travel Allowance',
            'Medical Reimbursement',
            'Accommodation',
            'Meal Allowance',
        ];

        $statuses = [
            'Initiated',
            'Submitted',
            'Approved',
            'Rejected',
        ];

        return view('claim.my-claims', compact('claims', 'events', 'statuses'));
    }

    public function assignClaim()
    {
        // Sample dropdown options (static prototype data)
        $events = [
            'Travel Allowance',
            'Medical Reimbursement',
            'Accommodation',
            'Meal Allowance',
        ];

        $currencies = [
            'Afghanistan Afghani',
            'Algerian Dinar',
            'Argentine Peso',
            'Australian Dollar',
            'Bangladeshi Taka',
            'Brazilian Real',
            'Canadian Dollar',
            'Chinese Yuan',
            'Danish Krone',
            'US Dollar',
            'Euro',
            'British Pound',
            'Hong Kong Dollar',
            'Indian Rupee',
            'Indonesian Rupiah',
            'Japanese Yen',
            'Malaysian Ringgit',
            'Mexican Peso',
            'New Zealand Dollar',
            'Norwegian Krone',
            'Pakistani Rupee',
            'Philippine Peso',
            'Saudi Riyal',
            'Singapore Dollar',
            'South African Rand',
            'South Korean Won',
            'Sri Lankan Rupee',
            'Swedish Krona',
            'Swiss Franc',
            'Thai Baht',
            'Turkish Lira',
            'UAE Dirham',
        ];

        return view('claim.assign-claim', compact('events', 'currencies'));
    }

    public function events()
    {
        // Sample events data
        $events = [
            [
                'id' => 1,
                'event_name' => 'Accommodation',
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'event_name' => 'Medical Reimbursement',
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'event_name' => 'Travel Allowance',
                'status' => 'Active',
            ],
        ];

        $statuses = [
            'Active',
            'Inactive',
        ];

        return view('claim.configuration.events', compact('events', 'statuses'));
    }

    public function addEvent()
    {
        return view('claim.configuration.add-event');
    }

    public function expensesTypes()
    {
        // Sample expense types data
        $expenseTypes = [
            [
                'id' => 1,
                'name' => 'Accommodation',
                'status' => 'Active',
            ],
            [
                'id' => 2,
                'name' => 'Fuel Allowance',
                'status' => 'Active',
            ],
            [
                'id' => 3,
                'name' => 'Planned Surgery',
                'status' => 'Active',
            ],
            [
                'id' => 4,
                'name' => 'Transport',
                'status' => 'Active',
            ],
        ];

        $statuses = [
            'Active',
            'Inactive',
        ];

        return view('claim.configuration.expenses-types', compact('expenseTypes', 'statuses'));
    }

    public function addExpenseType()
    {
        return view('claim.configuration.add-expense-type');
    }
}

