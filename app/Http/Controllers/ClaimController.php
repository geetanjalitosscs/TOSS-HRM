<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('claim_requests')
            ->join('employees', 'claim_requests.employee_id', '=', 'employees.id')
            ->leftJoin('claim_items', 'claim_items.claim_request_id', '=', 'claim_requests.id')
            ->leftJoin('claim_events', 'claim_events.id', '=', 'claim_items.claim_event_id');

        // Search filters
        if ($request->filled('employee_id')) {
            $query->where('claim_requests.employee_id', $request->input('employee_id'));
        }

        if ($request->filled('reference_id')) {
            $referenceId = $request->input('reference_id');
            $query->whereRaw("CONCAT(
                DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                LPAD(claim_requests.id, 6, '0')
            ) LIKE ?", ["%{$referenceId}%"]);
        }

        if ($request->filled('event_name')) {
            $query->where('claim_events.name', $request->input('event_name'));
        }

        if ($request->filled('status')) {
            $query->where('claim_requests.status', strtoupper($request->input('status')));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('claim_requests.claim_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('claim_requests.claim_date', '<=', $request->input('to_date'));
        }

        // Default to current employees only
        $query->where('employees.status', 'active')->whereNull('employees.deleted_at');

        $employees = DB::table('employees')
            ->whereNull('deleted_at')
            ->where('status', 'active')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as name"))
            ->orderBy('name')
            ->get();

        $claims = $query
            ->selectRaw("
                claim_requests.id,
                CONCAT(
                    DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                    LPAD(claim_requests.id, 6, '0')
                ) as reference_id,
                COALESCE(employees.display_name, CONCAT(employees.first_name, ' ', employees.last_name)) as employee_name,
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
                'employees.first_name',
                'employees.last_name',
                'claim_requests.remarks',
                'claim_requests.currency',
                'claim_requests.status',
                'claim_requests.total_amount'
            )
            ->orderByDesc('claim_requests.created_at')
            ->orderByDesc('claim_requests.id')
            ->get();

        return view('claim.claim', compact('claims', 'employees'));
    }

    public function cancelClaim(Request $request, int $id)
    {
        DB::table('claim_requests')
            ->where('id', $id)
            ->update([
                'status' => 'cancelled',
                'updated_at' => now(),
            ]);

        $redirectTo = $request->input('redirect_to', 'claim');
        $route = $redirectTo === 'my-claims' ? 'claim.my-claims' : 'claim';
        $hash = $redirectTo === 'my-claims' ? '#my-claims-table-section' : '#claims-table-section';

        return redirect()->to(route($route) . $hash)
            ->with('status', 'Claim cancelled successfully.');
    }

    public function rejectClaim(Request $request, int $id)
    {
        DB::table('claim_requests')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now(),
            ]);

        $redirectTo = $request->input('redirect_to', 'claim');
        $route = $redirectTo === 'my-claims' ? 'claim.my-claims' : 'claim';
        $hash = $redirectTo === 'my-claims' ? '#my-claims-table-section' : '#claims-table-section';

        return redirect()->to(route($route) . $hash)
            ->with('status', 'Claim rejected successfully.');
    }

    public function approveClaim(Request $request, int $id)
    {
        DB::table('claim_requests')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'approved_at' => now(),
                'updated_at' => now(),
            ]);

        $redirectTo = $request->input('redirect_to', 'claim');
        $route = $redirectTo === 'my-claims' ? 'claim.my-claims' : 'claim';
        $hash = $redirectTo === 'my-claims' ? '#my-claims-table-section' : '#claims-table-section';

        return redirect()->to(route($route) . $hash)
            ->with('status', 'Claim approved successfully.');
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

    public function myClaims(Request $request)
    {
        // Get current logged in user's employee_id
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        if (!$userId) {
            abort(403);
        }

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || !$user->employee_id) {
            abort(404);
        }

        $employeeId = $user->employee_id;

        // Show only claims submitted by current user (where submitted_at is not null)
        $query = DB::table('claim_requests')
            ->join('employees', 'claim_requests.employee_id', '=', 'employees.id')
            ->leftJoin('claim_items', 'claim_items.claim_request_id', '=', 'claim_requests.id')
            ->leftJoin('claim_events', 'claim_events.id', '=', 'claim_items.claim_event_id')
            ->where('claim_requests.employee_id', $employeeId)
            ->whereNotNull('claim_requests.submitted_at'); // Only submitted claims (not assigned)

        // Search filters
        if ($request->filled('reference_id')) {
            $referenceId = $request->input('reference_id');
            $query->whereRaw("CONCAT(
                DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                LPAD(claim_requests.id, 6, '0')
            ) LIKE ?", ["%{$referenceId}%"]);
        }

        if ($request->filled('event_name')) {
            $query->where('claim_events.name', $request->input('event_name'));
        }

        if ($request->filled('status')) {
            $query->where('claim_requests.status', strtoupper($request->input('status')));
        }

        if ($request->filled('from_date')) {
            $query->whereDate('claim_requests.claim_date', '>=', $request->input('from_date'));
        }

        if ($request->filled('to_date')) {
            $query->whereDate('claim_requests.claim_date', '<=', $request->input('to_date'));
        }

        $claims = $query
            ->selectRaw("
                claim_requests.id,
                CONCAT(
                    DATE_FORMAT(claim_requests.claim_date, '%Y%m%d'),
                    LPAD(claim_requests.id, 6, '0')
                ) as reference_id,
                COALESCE(employees.display_name, CONCAT(employees.first_name, ' ', employees.last_name)) as employee_name,
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
                'employees.first_name',
                'employees.last_name',
                'claim_requests.remarks',
                'claim_requests.currency',
                'claim_requests.status',
                'claim_requests.total_amount'
            )
            ->orderByDesc('claim_requests.created_at')
            ->orderByDesc('claim_requests.id')
            ->get();

        $events = DB::table('claim_events')
            ->where('is_active', 1)
            ->orderBy('name')
            ->pluck('name');

        $statuses = [
            'DRAFT',
            'SUBMITTED',
            'APPROVED',
            'REJECTED',
            'CANCELLED',
        ];

        return view('claim.my-claims', compact('claims', 'events', 'statuses'));
    }

    public function assignClaim()
    {
        $events = DB::table('claim_events')
            ->where('is_active', 1)
            ->orderBy('name')
            ->pluck('name');

        $employees = DB::table('employees')
            ->whereNull('deleted_at')
            ->select('id', DB::raw("COALESCE(display_name, CONCAT(first_name, ' ', last_name)) as name"))
            ->orderBy('name')
            ->get();

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

        return view('claim.assign-claim', compact('events', 'currencies', 'employees'));
    }

    public function storeAssignClaim(Request $request)
    {
        $data = $request->validate([
            'employee_id' => ['required', 'integer', 'exists:employees,id'],
            'event' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        $employeeId = $data['employee_id'];

        // Get event ID from name
        $event = DB::table('claim_events')
            ->where('name', $data['event'])
            ->where('is_active', 1)
            ->first();

        if (!$event) {
            return back()->withErrors(['event' => 'Invalid event selected.'])->withInput();
        }

        // Extract currency code
        $currencyCode = $this->getCurrencyCode($data['currency']);
        $price = $data['price'];

        // Create claim request (assigned - submitted_at is null)
        $claimRequestId = DB::table('claim_requests')->insertGetId([
            'employee_id' => $employeeId,
            'claim_date' => now()->toDateString(),
            'total_amount' => $price,
            'currency' => $currencyCode,
            'status' => 'draft', // Assigned claims start as draft
            'submitted_at' => null, // Not submitted by user, assigned by admin
            'remarks' => $data['remarks'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create claim item
        DB::table('claim_items')->insert([
            'claim_request_id' => $claimRequestId,
            'claim_event_id' => $event->id,
            'item_date' => now()->toDateString(),
            'description' => $data['remarks'] ?? null,
            'amount' => $price,
            'currency' => $currencyCode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('claim') . '#claims-table-section')
            ->with('status', 'Claim assigned successfully.');
    }

    public function storeSubmitClaim(Request $request)
    {
        $data = $request->validate([
            'event' => ['required', 'string'],
            'currency' => ['required', 'string'],
            'price' => ['required', 'integer', 'min:0'],
            'remarks' => ['nullable', 'string', 'max:255'],
        ]);

        // Get current logged in user's employee_id
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        if (!$userId) {
            return back()->withErrors(['error' => 'User not authenticated.'])->withInput();
        }

        $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || !$user->employee_id) {
            return back()->withErrors(['error' => 'Employee ID not found.'])->withInput();
        }

        $employeeId = $user->employee_id;

        // Get event ID from name
        $event = DB::table('claim_events')
            ->where('name', $data['event'])
            ->where('is_active', 1)
            ->first();

        if (!$event) {
            return back()->withErrors(['event' => 'Invalid event selected.'])->withInput();
        }

        // Extract currency code (first 3 characters or map full name to code)
        $currencyCode = $this->getCurrencyCode($data['currency']);

        $price = $data['price'];

        // Create claim request (submitted by user - submitted_at is set, but status is draft)
        $claimRequestId = DB::table('claim_requests')->insertGetId([
            'employee_id' => $employeeId,
            'claim_date' => now()->toDateString(),
            'total_amount' => $price,
            'currency' => $currencyCode,
            'status' => 'draft',
            'submitted_at' => now(), // User submitted it, so submitted_at is set
            'remarks' => $data['remarks'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create claim item
        DB::table('claim_items')->insert([
            'claim_request_id' => $claimRequestId,
            'claim_event_id' => $event->id,
            'item_date' => now()->toDateString(),
            'description' => $data['remarks'] ?? null,
            'amount' => $price,
            'currency' => $currencyCode,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('claim.my-claims') . '#my-claims-table-section')
            ->with('status', 'Claim submitted successfully.');
    }

    private function getCurrencyCode($currencyName)
    {
        $currencyMap = [
            'US Dollar' => 'USD',
            'Euro' => 'EUR',
            'British Pound' => 'GBP',
            'Indian Rupee' => 'INR',
            'Japanese Yen' => 'JPY',
            'Australian Dollar' => 'AUD',
            'Canadian Dollar' => 'CAD',
            'Singapore Dollar' => 'SGD',
            'Hong Kong Dollar' => 'HKD',
            'Swiss Franc' => 'CHF',
            'Chinese Yuan' => 'CNY',
            'Thai Baht' => 'THB',
            'Malaysian Ringgit' => 'MYR',
            'Indonesian Rupiah' => 'IDR',
            'Philippine Peso' => 'PHP',
            'South Korean Won' => 'KRW',
            'New Zealand Dollar' => 'NZD',
            'Saudi Riyal' => 'SAR',
            'UAE Dirham' => 'AED',
            'Turkish Lira' => 'TRY',
            'South African Rand' => 'ZAR',
            'Pakistani Rupee' => 'PKR',
            'Bangladeshi Taka' => 'BDT',
            'Sri Lankan Rupee' => 'LKR',
            'Afghanistan Afghani' => 'AFN',
            'Algerian Dinar' => 'DZD',
            'Argentine Peso' => 'ARS',
            'Brazilian Real' => 'BRL',
            'Danish Krone' => 'DKK',
            'Norwegian Krone' => 'NOK',
            'Swedish Krona' => 'SEK',
            'Mexican Peso' => 'MXN',
        ];

        return $currencyMap[$currencyName] ?? 'USD';
    }

    public function events(Request $request)
    {
        $eventName = $request->input('event_name');
        $status = $request->input('status');

        $query = DB::table('claim_events')
            ->select(
                'id',
                'name',
                'description',
                'max_amount',
                DB::raw("CASE WHEN is_active = 1 THEN 'Active' ELSE 'Inactive' END as status")
            );

        if ($eventName) {
            $query->where('name', 'like', '%' . $eventName . '%');
        }

        if ($status) {
            $query->where('is_active', $status === 'Active' ? 1 : 0);
        }

        $events = $query->orderByDesc('id')->get();

        $statuses = ['Active', 'Inactive'];

        return view('claim.configuration.events', compact('events', 'statuses'));
    }

    public function addEvent()
    {
        return view('claim.configuration.add-event');
    }

    public function editEvent($id)
    {
        $raw = DB::table('claim_events')
            ->select('id', 'name', 'description', 'max_amount', 'is_active')
            ->where('id', $id)
            ->first();

        if (!$raw) {
            abort(404);
        }

        $event = (object) [
            'id' => $raw->id,
            'name' => $raw->name,
            'description' => $raw->description,
            'max_amount' => $raw->max_amount,
            'status' => $raw->is_active ? 'Active' : 'Inactive',
        ];

        return view('claim.configuration.edit-event', compact('event'));
    }

    public function expensesTypes(Request $request)
    {
        $name = $request->input('name');
        $status = $request->input('status');

        $query = DB::table('claim_expense_types')
            ->select(
                'id',
                'name',
                'description',
                DB::raw("CASE WHEN is_active = 1 THEN 'Active' ELSE 'Inactive' END as status")
            );

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        if ($status) {
            $query->where('is_active', $status === 'Active' ? 1 : 0);
        }

        $expenseTypes = $query->orderByDesc('id')->get();

        $statuses = ['Active', 'Inactive'];

        return view('claim.configuration.expenses-types', compact('expenseTypes', 'statuses'));
    }

    public function addExpenseType()
    {
        return view('claim.configuration.add-expense-type');
    }

    public function editExpenseType($id)
    {
        $raw = DB::table('claim_expense_types')
            ->select('id', 'name', 'description', 'is_active')
            ->where('id', $id)
            ->first();

        if (!$raw) {
            abort(404);
        }

        $expenseType = (object) [
            'id' => $raw->id,
            'name' => $raw->name,
            'description' => $raw->description,
            'status' => $raw->is_active ? 'Active' : 'Inactive',
        ];

        return view('claim.configuration.edit-expense-type', compact('expenseType'));
    }

    public function storeEvent(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'max_amount' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::table('claim_events')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'max_amount' => isset($data['max_amount']) ? (int)$data['max_amount'] : null,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('claim.configuration.events') . '#events-table-section')
            ->with('status', 'Event added.');
    }

    public function updateEvent(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'max_amount' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::table('claim_events')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'max_amount' => isset($data['max_amount']) ? (int)$data['max_amount'] : null,
                'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
                'updated_at' => now(),
            ]);

        return redirect()->to(route('claim.configuration.events') . '#events-table-section')
            ->with('status', 'Event updated.');
    }

    public function deleteEvent(int $id)
    {
        DB::table('claim_events')->where('id', $id)->delete();

        return redirect()->to(route('claim.configuration.events') . '#events-table-section')
            ->with('status', 'Event deleted.');
    }

    public function bulkDeleteEvents(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('claim.configuration.events')
                ->with('status', 'No events selected.');
        }

        DB::table('claim_events')->whereIn('id', $ids)->delete();

        return redirect()->to(route('claim.configuration.events') . '#events-table-section')
            ->with('status', count($ids) . ' event(s) deleted.');
    }

    public function storeExpenseType(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::table('claim_expense_types')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('claim.configuration.expenses-types') . '#expense-types-table-section')
            ->with('status', 'Expense type added.');
    }

    public function updateExpenseType(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::table('claim_expense_types')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1,
                'updated_at' => now(),
            ]);

        return redirect()->to(route('claim.configuration.expenses-types') . '#expense-types-table-section')
            ->with('status', 'Expense type updated.');
    }

    public function deleteExpenseType(int $id)
    {
        DB::table('claim_expense_types')->where('id', $id)->delete();

        return redirect()->to(route('claim.configuration.expenses-types') . '#expense-types-table-section')
            ->with('status', 'Expense type deleted.');
    }

    public function bulkDeleteClaims(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            $redirectTo = $request->input('redirect_to', 'claim');
            $route = $redirectTo === 'my-claims' ? 'claim.my-claims' : 'claim';
            $hash = $redirectTo === 'my-claims' ? '#my-claims-table-section' : '#claims-table-section';
            return redirect()->to(route($route) . $hash)
                ->with('status', 'No claims selected.');
        }

        // Delete claim items first (foreign key constraint)
        DB::table('claim_items')->whereIn('claim_request_id', $ids)->delete();
        
        // Delete claim requests
        DB::table('claim_requests')->whereIn('id', $ids)->delete();

        $redirectTo = $request->input('redirect_to', 'claim');
        $route = $redirectTo === 'my-claims' ? 'claim.my-claims' : 'claim';
        $hash = $redirectTo === 'my-claims' ? '#my-claims-table-section' : '#claims-table-section';

        return redirect()->to(route($route) . $hash)
            ->with('status', count($ids) . ' claim(s) deleted.');
    }

    public function bulkDeleteExpenseTypes(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('claim.configuration.expenses-types')
                ->with('status', 'No expense types selected.');
        }

        DB::table('claim_expense_types')->whereIn('id', $ids)->delete();

        return redirect()->to(route('claim.configuration.expenses-types') . '#expense-types-table-section')
            ->with('status', count($ids) . ' expense type(s) deleted.');
    }
}

