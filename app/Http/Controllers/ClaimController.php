<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = DB::table('claim_requests')
            ->join('employees', 'claim_requests.employee_id', '=', 'employees.id')
            ->leftJoin('claim_items', 'claim_items.claim_request_id', '=', 'claim_requests.id')
            ->leftJoin('claim_events', 'claim_events.id', '=', 'claim_items.claim_event_id')
            ->selectRaw("
                claim_requests.id,
                CONCAT(
                    DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                    LPAD(claim_requests.id, 6, '0')
                ) as reference_id,
                employees.display_name as employee_name,
                COALESCE(MAX(claim_events.name), 'N/A') as event_name,
                claim_requests.remarks as description,
                claim_requests.currency,
                DATE_FORMAT(claim_requests.claim_date, '%Y-%m-%d') as submitted_date,
                UPPER(claim_requests.status) as status,
                claim_requests.total_amount as amount
            ")
            ->groupBy(
                'claim_requests.id',
                'claim_requests.claim_date',
                'employees.display_name',
                'claim_requests.remarks',
                'claim_requests.currency',
                'claim_requests.status',
                'claim_requests.total_amount'
            )
            ->orderByDesc('claim_requests.claim_date')
            ->get();

        return view('claim.claim', compact('claims'));
    }

    public function submit()
    {
        // Events from DB
        $events = DB::table('claim_events')
            ->where('is_active', 1)
            ->orderBy('name')
            ->pluck('name');

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
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $claims = DB::table('claim_requests')
            ->join('employees', 'claim_requests.employee_id', '=', 'employees.id')
            ->leftJoin('claim_items', 'claim_items.claim_request_id', '=', 'claim_requests.id')
            ->leftJoin('claim_events', 'claim_events.id', '=', 'claim_items.claim_event_id')
            ->where('claim_requests.employee_id', $employeeId)
            ->selectRaw("
                claim_requests.id,
                CONCAT(
                    DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                    LPAD(claim_requests.id, 6, '0')
                ) as reference_id,
                employees.display_name as employee_name,
                COALESCE(MAX(claim_events.name), 'N/A') as event_name,
                claim_requests.remarks as description,
                claim_requests.currency,
                DATE_FORMAT(claim_requests.claim_date, '%Y-%m-%d') as submitted_date,
                UPPER(claim_requests.status) as status,
                claim_requests.total_amount as amount
            ")
            ->groupBy(
                'claim_requests.id',
                'claim_requests.claim_date',
                'employees.display_name',
                'claim_requests.remarks',
                'claim_requests.currency',
                'claim_requests.status',
                'claim_requests.total_amount'
            )
            ->orderByDesc('claim_requests.claim_date')
            ->get();

        $events = DB::table('claim_events')
            ->where('is_active', 1)
            ->orderBy('name')
            ->pluck('name');

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
        $events = DB::table('claim_events')
            ->where('is_active', 1)
            ->orderBy('name')
            ->pluck('name');

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
        $events = DB::table('claim_events')
            ->select(
                'id',
                'name',
                DB::raw("CASE WHEN is_active = 1 THEN 'Active' ELSE 'Inactive' END as status")
            )
            ->orderBy('name')
            ->get();

        $statuses = ['Active', 'Inactive'];

        return view('claim.configuration.events', compact('events', 'statuses'));
    }

    public function addEvent()
    {
        return view('claim.configuration.add-event');
    }

    public function expensesTypes()
    {
        $expenseTypes = DB::table('claim_expense_types')
            ->select(
                'id',
                'name',
                DB::raw("CASE WHEN is_active = 1 THEN 'Active' ELSE 'Inactive' END as status")
            )
            ->orderBy('name')
            ->get();

        $statuses = ['Active', 'Inactive'];

        return view('claim.configuration.expenses-types', compact('expenseTypes', 'statuses'));
    }

    public function addExpenseType()
    {
        return view('claim.configuration.add-expense-type');
    }
}

