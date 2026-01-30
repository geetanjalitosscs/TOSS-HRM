<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index()
    {
        return redirect()->route('leave.leave-list');
    }

    public function apply()
    {
        // Get current logged-in user's employee information
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        $employeeId = null;
        $employeeName = null;
        
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            if ($user && $user->employee_id) {
                $employeeId = $user->employee_id;
                $employee = DB::table('employees')
                    ->where('id', $employeeId)
                    ->select('id', 'display_name')
                    ->first();
                if ($employee) {
                    $employeeName = $employee->display_name;
                }
            }
        }

        // Leave type options for the apply form
        $leaveTypes = DB::table('leave_types')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('leave.apply', compact('employeeId', 'employeeName', 'leaveTypes'));
    }

    public function store(Request $request)
    {
        // Get current logged-in user's employee_id
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        $employeeId = null;
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            if ($user && $user->employee_id) {
                $employeeId = $user->employee_id;
            }
        }

        if (!$employeeId) {
            return redirect()->route('leave.apply')
                ->withErrors(['employee' => 'Employee information not found. Please contact administrator.']);
        }

        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        DB::table('leave_applications')->insert([
            'employee_id' => $employeeId,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->from_date,
            'end_date' => $request->to_date,
            'total_days' => $totalDays,
            'status' => 'pending',
            'reason' => $request->reason ?? null,
            'applied_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('leave.leave-list')->with('success', 'Leave application submitted successfully.');
    }

    public function myLeave(Request $request)
    {
        // Get current logged-in user's employee_id
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        $employeeId = null;
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            if ($user && $user->employee_id) {
                $employeeId = $user->employee_id;
            }
        }

        if (!$employeeId) {
            $leaves = collect();
            $leaveTypes = collect();
            return view('leave.my-leave', compact('leaves', 'leaveTypes'));
        }

        // Get filter values from request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status');
        $leaveTypeId = $request->input('leave_type_id');

        // Get leave types for dropdown
        $leaveTypes = DB::table('leave_types')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $query = DB::table('leave_applications')
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->where('leave_applications.employee_id', $employeeId);

        // Apply date filters: if only from_date, show >= from_date; if only to_date, show <= to_date; if both, show overlapping range
        if ($fromDate && $toDate) {
            // Both dates provided: show leaves where date range overlaps with search range
            $query->where(function ($q) use ($fromDate, $toDate) {
                $q->where(function ($subQ) use ($fromDate, $toDate) {
                    // Leave starts before or on to_date and ends on or after from_date
                    $subQ->where('leave_applications.start_date', '<=', $toDate)
                         ->where('leave_applications.end_date', '>=', $fromDate);
                });
            });
        } elseif ($fromDate) {
            // Only from_date: show leaves where start_date >= from_date OR end_date >= from_date
            $query->where(function ($q) use ($fromDate) {
                $q->where('leave_applications.start_date', '>=', $fromDate)
                  ->orWhere('leave_applications.end_date', '>=', $fromDate);
            });
        } elseif ($toDate) {
            // Only to_date: show leaves where start_date <= to_date OR end_date <= to_date
            $query->where(function ($q) use ($toDate) {
                $q->where('leave_applications.start_date', '<=', $toDate)
                  ->orWhere('leave_applications.end_date', '<=', $toDate);
            });
        }
        
        if ($status) {
            $query->where('leave_applications.status', $status);
        }
        if ($leaveTypeId) {
            $query->where('leave_applications.leave_type_id', $leaveTypeId);
        }

        $leaves = $query->select(
                'leave_applications.id',
                'leave_applications.start_date',
                'leave_applications.end_date',
                DB::raw("DATE_FORMAT(leave_applications.start_date, '%Y-%m-%d') as start_date_formatted"),
                DB::raw("DATE_FORMAT(leave_applications.end_date, '%Y-%m-%d') as end_date_formatted"),
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_types.id as leave_type_id',
                'leave_types.max_per_year',
                'leave_types.calculate_monthly',
                'leave_applications.total_days as number_of_days',
                'leave_applications.status',
                'leave_applications.reason as comments'
            )
            ->orderByDesc('leave_applications.start_date')
            ->get();

        // Calculate leave balance for each leave type
        $leaveBalances = [];
        foreach ($leaves as $leave) {
            $leaveTypeId = $leave->leave_type_id;
            if (!isset($leaveBalances[$leaveTypeId])) {
                $maxPerYear = $leave->max_per_year ?? 0;
                $calculateMonthly = $leave->calculate_monthly ?? 0;
                
                if ($calculateMonthly == 1) {
                    // Monthly calculation
                    $leavesPerMonth = $maxPerYear / 12;
                    $monthlyAllocation = round($leavesPerMonth, 2);
                    
                    $today = Carbon::today();
                    $currentYear = $today->year;
                    $currentMonth = $today->month;
                    
                    $monthlyBalance = 0;
                    for ($month = 1; $month <= $currentMonth; $month++) {
                        $daysTakenInMonth = DB::table('leave_applications')
                            ->where('employee_id', $employeeId)
                            ->where('leave_type_id', $leaveTypeId)
                            ->where('status', '!=', 'cancelled')
                            ->whereYear('start_date', $currentYear)
                            ->whereMonth('start_date', $month)
                            ->sum('total_days');
                        $daysTakenInMonth = $daysTakenInMonth ?? 0;
                        
                        $monthlyBalance += $leavesPerMonth;
                        $monthlyBalance -= $daysTakenInMonth;
                    }
                    
                    $remaining = round($monthlyBalance, 2);
                    $displayTotal = $monthlyAllocation;
                    $totalTaken = 0; // Not used for monthly, but keep for compatibility
                } else {
                    // Yearly calculation
                    $totalTaken = DB::table('leave_applications')
                        ->where('employee_id', $employeeId)
                        ->where('leave_type_id', $leaveTypeId)
                        ->where('status', '!=', 'cancelled')
                        ->sum('total_days');
                    $totalTaken = $totalTaken ?? 0;
                    $remaining = $maxPerYear - $totalTaken;
                    $displayTotal = $maxPerYear;
                }
                
                $leaveBalances[$leaveTypeId] = [
                    'leave_type' => $leave->leave_type,
                    'max_per_year' => $maxPerYear,
                    'total_taken' => $totalTaken,
                    'remaining' => $remaining,
                    'display_total' => $displayTotal,
                    'calculate_monthly' => $calculateMonthly
                ];
            }
        }

        return view('leave.my-leave', compact('leaves', 'leaveTypes', 'leaveBalances'));
    }

    public function leaveList(Request $request)
    {
        // Get filter values from request
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');
        $status = $request->input('status');
        $leaveTypeId = $request->input('leave_type_id');
        $employeeName = $request->input('employee_name');

        // Get leave types for dropdown
        $leaveTypes = DB::table('leave_types')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $query = DB::table('leave_applications')
            ->join('employees', 'leave_applications.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_applications.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('leave_entitlements', function ($join) {
                $join->on('leave_entitlements.employee_id', '=', 'leave_applications.employee_id')
                    ->on('leave_entitlements.leave_type_id', '=', 'leave_applications.leave_type_id');
            });

        // Apply date filters: if only from_date, show >= from_date; if only to_date, show <= to_date; if both, show overlapping range
        if ($fromDate && $toDate) {
            // Both dates provided: show leaves where date range overlaps with search range
            $query->where(function ($q) use ($fromDate, $toDate) {
                $q->where(function ($subQ) use ($fromDate, $toDate) {
                    // Leave starts before or on to_date and ends on or after from_date
                    $subQ->where('leave_applications.start_date', '<=', $toDate)
                         ->where('leave_applications.end_date', '>=', $fromDate);
                });
            });
        } elseif ($fromDate) {
            // Only from_date: show leaves where start_date >= from_date OR end_date >= from_date
            $query->where(function ($q) use ($fromDate) {
                $q->where('leave_applications.start_date', '>=', $fromDate)
                  ->orWhere('leave_applications.end_date', '>=', $fromDate);
            });
        } elseif ($toDate) {
            // Only to_date: show leaves where start_date <= to_date OR end_date <= to_date
            $query->where(function ($q) use ($toDate) {
                $q->where('leave_applications.start_date', '<=', $toDate)
                  ->orWhere('leave_applications.end_date', '<=', $toDate);
            });
        }
        
        if ($status) {
            $query->where('leave_applications.status', $status);
        }
        if ($leaveTypeId) {
            $query->where('leave_applications.leave_type_id', $leaveTypeId);
        }
        if ($employeeName) {
            $query->where('employees.display_name', 'like', '%' . $employeeName . '%');
        }

        $leaves = $query->select(
                'leave_applications.id',
                'leave_applications.employee_id',
                'leave_applications.start_date',
                'leave_applications.end_date',
                DB::raw("DATE_FORMAT(leave_applications.start_date, '%Y-%m-%d') as start_date_formatted"),
                DB::raw("DATE_FORMAT(leave_applications.end_date, '%Y-%m-%d') as end_date_formatted"),
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_types.id as leave_type_id',
                'leave_types.max_per_year',
                'leave_types.calculate_monthly',
                DB::raw("COALESCE(leave_entitlements.days_used, 0) as days_used"),
                'leave_applications.total_days as number_of_days',
                'leave_applications.status',
                'leave_applications.reason as comments'
            )
            ->orderByDesc('leave_applications.start_date')
            ->get();

        // Calculate leave balance in format "total/remaining" for each leave record
        $leaves = $leaves->map(function ($leave) {
            $maxPerYear = $leave->max_per_year ?? 0;
            $calculateMonthly = $leave->calculate_monthly ?? 0;
            
            // Check if monthly calculation is enabled
            if ($calculateMonthly == 1) {
                // Convert yearly to monthly: max_per_year / 12 = leaves per month
                $leavesPerMonth = $maxPerYear / 12;
                $monthlyAllocation = round($leavesPerMonth, 2); // e.g., 12/12 = 1
                
                $today = Carbon::today();
                $currentYear = $today->year;
                $currentMonth = $today->month;
                
                // Calculate monthly balance with carry-forward logic
                $remaining = 0;
                $monthlyBalance = 0; // Track cumulative balance month by month
                
                for ($month = 1; $month <= $currentMonth; $month++) {
                    // Get total days taken in this month
                    $daysTakenInMonth = DB::table('leave_applications')
                        ->where('employee_id', $leave->employee_id)
                        ->where('leave_type_id', $leave->leave_type_id)
                        ->where('status', '!=', 'cancelled')
                        ->whereYear('start_date', $currentYear)
                        ->whereMonth('start_date', $month)
                        ->sum('total_days');
                    $daysTakenInMonth = $daysTakenInMonth ?? 0;
                    
                    // Add monthly allocation (1 leave per month)
                    $monthlyBalance += $leavesPerMonth;
                    
                    // Subtract days taken in this month
                    $monthlyBalance -= $daysTakenInMonth;
                    
                    // If balance goes negative, it carries forward to next month
                    // Next month's allocation will be reduced by the negative balance
                }
                
                // Final remaining balance (can be negative if overused)
                $remaining = round($monthlyBalance, 2);
                
                // Format as "monthly_allocation/remaining" (e.g., "1/-2" instead of "12/-1")
                $leave->leave_balance = number_format((float)$monthlyAllocation, 0, '.', '') . '/' . number_format((float)$remaining, 0, '.', '');
            } else {
                // For Sick Leave and Annual Leave: simple total - taken calculation
                $totalTaken = DB::table('leave_applications')
                    ->where('employee_id', $leave->employee_id)
                    ->where('leave_type_id', $leave->leave_type_id)
                    ->where('status', '!=', 'cancelled')
                    ->sum('total_days');
                $totalTaken = $totalTaken ?? 0;
                
                $remaining = $maxPerYear - $totalTaken;
                
                // Format as "total/remaining" (e.g., "10/3" or "5/2")
                $leave->leave_balance = number_format((float)$maxPerYear, 0, '.', '') . '/' . number_format((float)$remaining, 0, '.', '');
            }

            return $leave;
        });

        return view('leave.leave-list', compact('leaves', 'leaveTypes'));
    }

    public function assignLeave()
    {
        // Get current logged-in user's employee_id to exclude from dropdown
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;
        
        $currentEmployeeId = null;
        if ($userId) {
            $user = DB::table('users')->where('id', $userId)->first();
            if ($user && $user->employee_id) {
                $currentEmployeeId = $user->employee_id;
            }
        }

        // Get all employees except current user
        $employees = DB::table('employees')
            ->select('id', 'display_name')
            ->when($currentEmployeeId, function ($query) use ($currentEmployeeId) {
                $query->where('id', '!=', $currentEmployeeId);
            })
            ->orderBy('display_name')
            ->get();

        // Leave type options for the assign form
        $leaveTypes = DB::table('leave_types')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('leave.assign-leave', compact('employees', 'leaveTypes'));
    }

    public function storeAssignLeave(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type_id' => 'required|exists:leave_types,id',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        $startDate = Carbon::parse($request->from_date);
        $endDate = Carbon::parse($request->to_date);
        $totalDays = $startDate->diffInDays($endDate) + 1;

        DB::table('leave_applications')->insert([
            'employee_id' => $request->employee_id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->from_date,
            'end_date' => $request->to_date,
            'total_days' => $totalDays,
            'status' => 'approved', // Assigned leave is automatically approved
            'reason' => $request->reason ?? null,
            'applied_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('leave.leave-list')->with('success', 'Leave assigned successfully.');
    }

    public function getLeaveBalance(Request $request)
    {
        $employeeId = $request->input('employee_id');
        $leaveTypeId = $request->input('leave_type_id');

        if (!$employeeId || !$leaveTypeId) {
            return response()->json(['balance' => 0]);
        }

        // Get leave type to check if it's Casual Leave or Annual Leave
        $leaveType = DB::table('leave_types')
            ->where('id', $leaveTypeId)
            ->first();

        if (!$leaveType) {
            return response()->json(['balance' => 0]);
        }

        $isCasualLeave = $leaveType->name === 'Casual Leave';
        $isAnnualLeave = $leaveType->name === 'Annual Leave';

        if ($isCasualLeave || $isAnnualLeave) {
            // Calculate month-by-month balance
            $today = Carbon::today();
            $currentYear = $today->year;
            $currentMonth = $today->month;

            $balance = 0;
            for ($month = 1; $month <= $currentMonth; $month++) {
                $hasLeaveInMonth = DB::table('leave_applications')
                    ->where('employee_id', $employeeId)
                    ->where('leave_type_id', $leaveTypeId)
                    ->where('status', '!=', 'cancelled')
                    ->whereYear('start_date', $currentYear)
                    ->whereMonth('start_date', $month)
                    ->exists();

                if (!$hasLeaveInMonth) {
                    $balance += 1; // 1 leave per month if not taken
                }
            }

            return response()->json(['balance' => $balance]);
        } else {
            // Use max_per_year from leave_types for other leave types
            $entitlement = DB::table('leave_entitlements')
                ->where('employee_id', $employeeId)
                ->where('leave_type_id', $leaveTypeId)
                ->first();

            $maxPerYear = $leaveType->max_per_year ?? 0;
            $daysUsed = $entitlement ? $entitlement->days_used : 0;
            $balance = $maxPerYear - $daysUsed;

            return response()->json(['balance' => $balance]);
        }
    }

    // Entitlements
    public function addEntitlement()
    {
        return view('leave.add-entitlement');
    }

    public function myEntitlements()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $entitlements = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->select(
                'leave_types.name as leave_type',
                'leave_types.max_per_year as days_entitled',
                'leave_entitlements.days_used',
                DB::raw('(COALESCE(leave_types.max_per_year, 0) - COALESCE(leave_entitlements.days_used, 0)) as balance')
            )
            ->where('leave_entitlements.employee_id', $employeeId)
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.my-entitlements', compact('entitlements'));
    }

    public function employeeEntitlements()
    {
        // Fetch all employee entitlements with employee and leave type details
        $entitlements = DB::table('leave_entitlements')
            ->join('employees', 'leave_entitlements.employee_id', '=', 'employees.id')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->select(
                'leave_entitlements.id',
                'employees.display_name as employee_name',
                'leave_types.name as leave_type',
                'leave_types.max_per_year as days_entitled',
                'leave_entitlements.days_used',
                DB::raw('(COALESCE(leave_types.max_per_year, 0) - COALESCE(leave_entitlements.days_used, 0)) as balance')
            )
            ->orderBy('employees.display_name')
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.employee-entitlements', compact('entitlements'));
    }

    // Reports
    public function entitlementsUsageReport()
    {
        return view('leave.entitlements-usage-report');
    }

    public function myEntitlementsUsageReport()
    {
        // TODO: when auth is wired, resolve employee_id from logged-in user
        $employeeId = 1;

        $reportData = DB::table('leave_entitlements')
            ->join('leave_types', 'leave_entitlements.leave_type_id', '=', 'leave_types.id')
            ->leftJoin('leave_applications', function ($join) use ($employeeId) {
                $join->on('leave_applications.employee_id', '=', 'leave_entitlements.employee_id')
                    ->on('leave_applications.leave_type_id', '=', 'leave_entitlements.leave_type_id');
            })
            ->select(
                'leave_types.name as leave_type',
                'leave_types.max_per_year as days_entitled',
                DB::raw('COALESCE(SUM(leave_applications.total_days), 0) as days_taken'),
                DB::raw('(COALESCE(leave_types.max_per_year, 0) - COALESCE(SUM(leave_applications.total_days), 0)) as balance')
            )
            ->where('leave_entitlements.employee_id', $employeeId)
            ->groupBy('leave_types.name', 'leave_types.max_per_year')
            ->orderBy('leave_types.name')
            ->get();

        return view('leave.my-entitlements-usage-report', compact('reportData'));
    }

    // Configure
    public function leaveTypes(Request $request)
    {
        $search = $request->input('search', '');

        $query = DB::table('leave_types')
            ->select('id', 'name', 'code', 'is_paid', 'requires_approval', 'max_per_year', 'carry_forward', 'calculate_monthly')
            ->whereNull('deleted_at');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('code', 'like', '%' . $search . '%');
            });
        }

        $leaveTypes = $query->orderByDesc('id')->get();

        return view('leave.leave-types', compact('leaveTypes'));
    }

    /**
     * Store a new leave type.
     */
    public function storeLeaveType(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'is_paid' => ['nullable', 'boolean'],
            'requires_approval' => ['nullable', 'boolean'],
            'max_per_year' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'carry_forward' => ['nullable', 'boolean'],
        ]);

        // Auto-generate code from name (first letter of each word, max 2 letters)
        $words = explode(' ', trim($data['name']));
        $code = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $code .= strtoupper(substr($word, 0, 1));
                if (strlen($code) >= 2) break;
            }
        }
        // If we have less than 2 letters, pad with first letter
        if (strlen($code) < 2) {
            $code = strtoupper(substr($data['name'], 0, 2));
        }
        // If code already exists, append a number
        $originalCode = $code;
        $counter = 1;
        while (DB::table('leave_types')->where('code', $code)->exists()) {
            $code = $originalCode . $counter;
            $counter++;
        }

        DB::table('leave_types')->insert([
            'name' => $data['name'],
            'code' => $code,
            'is_paid' => isset($data['is_paid']) ? (int)$data['is_paid'] : 1,
            'requires_approval' => isset($data['requires_approval']) ? (int)$data['requires_approval'] : 1,
            'max_per_year' => !empty($data['max_per_year']) ? $data['max_per_year'] : null,
            'carry_forward' => isset($data['carry_forward']) ? (int)$data['carry_forward'] : 0,
            'calculate_monthly' => isset($data['calculate_monthly']) ? (int)$data['calculate_monthly'] : 0,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('leave.leave-types')
            ->with('status', 'Leave type added.');
    }

    /**
     * Update an existing leave type.
     */
    public function updateLeaveType(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'is_paid' => ['nullable', 'boolean'],
            'requires_approval' => ['nullable', 'boolean'],
            'max_per_year' => ['nullable', 'numeric', 'min:0', 'max:999'],
            'carry_forward' => ['nullable', 'boolean'],
            'calculate_monthly' => ['nullable', 'boolean'],
        ]);

        // Auto-generate code from name (first letter of each word, max 2 letters)
        $words = explode(' ', trim($data['name']));
        $code = '';
        foreach ($words as $word) {
            if (!empty($word)) {
                $code .= strtoupper(substr($word, 0, 1));
                if (strlen($code) >= 2) break;
            }
        }
        // If we have less than 2 letters, pad with first letter
        if (strlen($code) < 2) {
            $code = strtoupper(substr($data['name'], 0, 2));
        }
        // If code already exists for another record, append a number
        $originalCode = $code;
        $counter = 1;
        while (DB::table('leave_types')->where('code', $code)->where('id', '!=', $id)->exists()) {
            $code = $originalCode . $counter;
            $counter++;
        }

        DB::table('leave_types')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'code' => $code,
                'is_paid' => isset($data['is_paid']) ? (int)$data['is_paid'] : 1,
                'requires_approval' => isset($data['requires_approval']) ? (int)$data['requires_approval'] : 1,
                'max_per_year' => !empty($data['max_per_year']) ? $data['max_per_year'] : null,
                'carry_forward' => isset($data['carry_forward']) ? (int)$data['carry_forward'] : 0,
                'calculate_monthly' => isset($data['calculate_monthly']) ? (int)$data['calculate_monthly'] : 0,
                'updated_at' => now(),
            ]);

        return redirect()->route('leave.leave-types')
            ->with('status', 'Leave type updated.');
    }

    /**
     * Delete a leave type from the database.
     */
    public function deleteLeaveType(int $id)
    {
        DB::table('leave_types')
            ->where('id', $id)
            ->delete();

        return redirect()->route('leave.leave-types')
            ->with('status', 'Leave type deleted.');
    }

    /**
     * Bulk delete leave types from the database.
     */
    public function bulkDeleteLeaveTypes(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->all();

        if (!empty($ids)) {
            DB::table('leave_types')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('leave.leave-types')
            ->with('status', 'Selected leave types deleted.');
    }

    public function leavePeriod()
    {
        return view('leave.leave-period');
    }

    public function workWeek()
    {
        $dayNames = [
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
            7 => 'Sunday',
        ];

        $rows = DB::table('work_weeks')
            ->whereNull('location_id')
            ->orderBy('day_of_week')
            ->get();

        if ($rows->isEmpty()) {
            // Fallback to a default pattern if no DB rows exist yet
            $rows = collect(range(1, 7))->map(function ($day) {
                return (object)[
                    'day_of_week'   => $day,
                    'is_working_day'=> $day <= 5 ? 1 : 0,
                    'hours_per_day' => $day <= 5 ? 8.0 : 0.0,
                ];
            });
        }

        $days = $rows->map(function ($row) use ($dayNames) {
            $value = 'non_working';
            if ($row->is_working_day) {
                $value = $row->hours_per_day >= 7.5 ? 'full_day' : 'half_day';
            }

            $label = match ($value) {
                'full_day'    => 'Full Day',
                'half_day'    => 'Half Day',
                default       => 'Non-working Day',
            };

            return (object)[
                'day_of_week' => $row->day_of_week,
                'name'  => $dayNames[$row->day_of_week] ?? 'Day ' . $row->day_of_week,
                'value' => $value,
                'label' => $label,
            ];
        });

        return view('leave.work-week', compact('days'));
    }

    /**
     * Store work week configuration.
     */
    public function storeWorkWeek(Request $request)
    {
        $data = $request->validate([
            'days' => ['required', 'array'],
            'days.*' => ['required', 'string', 'in:full_day,half_day,non_working'],
        ]);

        foreach ($data['days'] as $dayOfWeek => $value) {
            $dayOfWeek = (int) $dayOfWeek;
            if ($dayOfWeek < 1 || $dayOfWeek > 7) {
                continue;
            }

            $isWorkingDay = ($value === 'full_day' || $value === 'half_day') ? 1 : 0;
            $hoursPerDay = match ($value) {
                'full_day' => 8.00,
                'half_day' => 4.00,
                default => 0.00,
            };

            // Check if record exists
            $existing = DB::table('work_weeks')
                ->whereNull('location_id')
                ->where('day_of_week', $dayOfWeek)
                ->first();

            if ($existing) {
                // Update existing record
                DB::table('work_weeks')
                    ->where('id', $existing->id)
                    ->update([
                        'is_working_day' => $isWorkingDay,
                        'hours_per_day' => $hoursPerDay,
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert new record
                DB::table('work_weeks')->insert([
                    'location_id' => null,
                    'day_of_week' => $dayOfWeek,
                    'is_working_day' => $isWorkingDay,
                    'hours_per_day' => $hoursPerDay,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('leave.work-week')
            ->with('status', 'Work week configuration saved successfully.');
    }

    public function holidays(Request $request)
    {
        $name = $request->input('name');
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        $query = DB::table('holidays')
            ->select(
                'id',
                'name',
                DB::raw("DATE_FORMAT(holiday_date, '%Y-%m-%d') as date"),
                DB::raw("COALESCE(is_full_day, 1) as is_full_day"),
                'is_recurring',
                DB::raw("CASE WHEN COALESCE(is_full_day, 1) = 1 THEN 'Full Day' ELSE 'Half Day' END as full_day_half_day"),
                DB::raw("CASE WHEN is_recurring = 1 THEN 'Yes' ELSE 'No' END as repeats")
            );

        // Name filter
        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Date filters: if only from_date, show >= from_date; if only to_date, show <= to_date; if both, show between
        if ($fromDate && $toDate) {
            // Both dates provided: show records in the date range
            $query->whereBetween('holiday_date', [$fromDate, $toDate]);
        } elseif ($fromDate) {
            // Only from_date: show records >= from_date
            $query->where('holiday_date', '>=', $fromDate);
        } elseif ($toDate) {
            // Only to_date: show records <= to_date
            $query->where('holiday_date', '<=', $toDate);
        }

        $holidays = $query->orderByDesc('id')->get();

        return view('leave.holidays', compact('holidays'));
    }

    /**
     * Store a new holiday.
     */
    public function storeHoliday(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'holiday_date' => ['required', 'date'],
            'is_full_day' => ['nullable', 'boolean'],
            'is_recurring' => ['nullable', 'boolean'],
        ]);

        DB::table('holidays')->insert([
            'name' => $data['name'],
            'holiday_date' => $data['holiday_date'],
            'is_full_day' => isset($data['is_full_day']) ? (int)$data['is_full_day'] : 1,
            'is_recurring' => isset($data['is_recurring']) ? (int)$data['is_recurring'] : 0,
            'location_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->to(route('leave.holidays') . '#holidays-table-section')
            ->with('status', 'Holiday added.');
    }

    /**
     * Update an existing holiday.
     */
    public function updateHoliday(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:191'],
            'holiday_date' => ['required', 'date'],
            'is_full_day' => ['nullable', 'boolean'],
            'is_recurring' => ['nullable', 'boolean'],
        ]);

        DB::table('holidays')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'holiday_date' => $data['holiday_date'],
                'is_full_day' => isset($data['is_full_day']) ? (int)$data['is_full_day'] : 1,
                'is_recurring' => isset($data['is_recurring']) ? (int)$data['is_recurring'] : 0,
                'updated_at' => now(),
            ]);

        return redirect()->to(route('leave.holidays') . '#holidays-table-section')
            ->with('status', 'Holiday updated.');
    }

    /**
     * Delete a holiday.
     */
    public function deleteHoliday(int $id)
    {
        DB::table('holidays')->where('id', $id)->delete();

        return redirect()->to(route('leave.holidays') . '#holidays-table-section')
            ->with('status', 'Holiday deleted.');
    }

    /**
     * Bulk delete holidays.
     */
    public function bulkDeleteHolidays(Request $request)
    {
        $data = $request->validate([
            'ids' => ['required', 'string'],
        ]);

        $ids = array_filter(explode(',', $data['ids']));
        
        if (empty($ids)) {
            return redirect()->route('leave.holidays')
                ->with('status', 'No holidays selected.');
        }

        DB::table('holidays')->whereIn('id', $ids)->delete();

        return redirect()->to(route('leave.holidays') . '#holidays-table-section')
            ->with('status', count($ids) . ' holiday(s) deleted.');
    }
}

