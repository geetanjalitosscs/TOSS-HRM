<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Timesheet;
use App\Models\TimesheetEntry;
use App\Models\AttendanceRecord;

class TimeController extends Controller
{
    /**
     * Resolve current user and employee ID.
     */
    private function resolveUserAndEmployee(): array
    {
        $authUser = session('auth_user');
        $userId = $authUser['id'] ?? null;

        if (!$userId) {
            abort(403, 'Unauthorized');
        }

            $user = DB::table('users')->where('id', $userId)->first();
        if (!$user || !$user->employee_id) {
            abort(404, 'Employee not found');
        }

        return [$userId, $user->employee_id];
    }

    /**
     * Get or create draft timesheet for current week.
     */
    private function getOrCreateCurrentWeekTimesheet($employeeId)
    {
        $today = Carbon::now();
        $weekStart = $today->copy()->startOfWeek(Carbon::MONDAY);
        $weekEnd = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $timesheet = DB::table('timesheets')
            ->where('employee_id', $employeeId)
            ->where(function($query) use ($weekStart, $weekEnd) {
                $query->whereBetween('week_start_date', [$weekStart, $weekEnd])
                      ->orWhereBetween('week_end_date', [$weekStart, $weekEnd])
                      ->orWhere(function($q) use ($weekStart, $weekEnd) {
                          $q->where('week_start_date', '<=', $weekStart)
                            ->where('week_end_date', '>=', $weekEnd);
                      });
            })
            ->where('status', 'draft')
            ->first();

        if (!$timesheet) {
            $timesheetId = DB::table('timesheets')->insertGetId([
                'employee_id' => $employeeId,
                'week_start_date' => $weekStart->toDateString(),
                'week_end_date' => $weekEnd->toDateString(),
                'start_date' => $weekStart->toDateString(),
                'end_date' => $weekEnd->toDateString(),
                'status' => 'draft',
                'total_hours' => 0.00,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $timesheet = DB::table('timesheets')->where('id', $timesheetId)->first();
        }

        return $timesheet;
    }

    // ============================================
    // TIMESHEETS - Employee Methods
    // ============================================

    /**
     * Show My Timesheet page.
     */
    public function myTimesheets()
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $timesheet = $this->getOrCreateCurrentWeekTimesheet($employeeId);
        
        $weekStart = Carbon::parse($timesheet->week_start_date ?? $timesheet->start_date);
        $weekEnd = Carbon::parse($timesheet->week_end_date ?? $timesheet->end_date);

        $days = [];
        $cursor = $weekStart->copy();
        while ($cursor->lte($weekEnd)) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day_of_month' => $cursor->format('d'),
                'day_name_short' => $cursor->format('D'),
            ];
            $cursor->addDay();
        }

        // Get all entries for this timesheet
        $entries = DB::table('timesheet_entries')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->where('timesheet_entries.timesheet_id', $timesheet->id)
            ->select(
                'timesheet_entries.id',
                'timesheet_entries.project_id',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheet_entries.notes',
                'timesheet_entries.created_at',
                'time_projects.name as project_name'
            )
            ->orderBy('timesheet_entries.work_date', 'asc')
            ->orderBy('timesheet_entries.created_at', 'asc')
            ->get();

        // Group entries by date - only show latest entry per date
        $groupedEntries = [];
        $entriesByDate = [];
        
        foreach ($entries as $entry) {
            $entryDate = Carbon::parse($entry->work_date)->format('Y-m-d');
            
            // Keep only the latest entry for each date (based on created_at)
            if (!isset($entriesByDate[$entryDate]) || 
                Carbon::parse($entry->created_at)->gt(Carbon::parse($entriesByDate[$entryDate]->created_at))) {
                $entriesByDate[$entryDate] = $entry;
            }
        }
        
        // Convert to array format
        foreach ($entriesByDate as $entry) {
            $groupedEntries[] = [
                'id' => $entry->id,
                'project_id' => $entry->project_id,
                'project_name' => $entry->project_name ?? '-',
                'activity_name' => $entry->activity_name ?? '-',
                'work_date' => $entry->work_date,
                'notes' => $entry->notes ?? '',
                'hours' => (float)$entry->hours,
            ];
        }
        
        // Sort by work_date descending (newest first)
        usort($groupedEntries, function($a, $b) {
            return strcmp($b['work_date'], $a['work_date']);
        });

        // Get projects for dropdown
        $projects = DB::table('time_projects')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        return view('time.my-timesheets', [
            'timesheet' => $timesheet,
            'days' => $days,
            'timesheetPeriod' => [
                'start' => $weekStart->toDateString(),
                'end' => $weekEnd->toDateString(),
            ],
            'status' => ucfirst($timesheet->status),
            'groupedEntries' => array_values($groupedEntries),
            'projects' => $projects,
        ]);
    }

    /**
     * Store a new timesheet entry.
     */
    public function storeEntry(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'timesheet_id' => ['required', 'exists:timesheets,id'],
            'project_id' => ['nullable', 'exists:time_projects,id'],
            'activity_name' => ['nullable', 'string', 'max:255'],
            'work_date' => ['required', 'date'],
            'hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'notes' => ['required', 'string', 'max:1000'],
        ]);

        // Set default hours to 0 if not provided
        $data['hours'] = $data['hours'] ?? 0;

        // Verify timesheet belongs to employee and is editable
        $timesheet = DB::table('timesheets')
            ->where('id', $data['timesheet_id'])
            ->where('employee_id', $employeeId)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if (!in_array($timesheet->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Cannot edit timesheet after submission');
        }

        // Create new entry
        DB::table('timesheet_entries')->insert([
            'timesheet_id' => $data['timesheet_id'],
            'project_id' => $data['project_id'] ?? null,
            'activity_name' => $data['activity_name'] ?? null,
            'work_date' => $data['work_date'],
            'hours' => $data['hours'],
            'notes' => $data['notes'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Recalculate total hours
        $this->recalculateTotal($data['timesheet_id']);

        return redirect()->route('time.my-timesheets')->with('status', 'Entry saved successfully');
    }

    /**
     * Update an existing timesheet entry.
     */
    public function updateEntry(Request $request, int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'project_id' => ['nullable', 'exists:time_projects,id'],
            'activity_name' => ['nullable', 'string', 'max:255'],
            'work_date' => ['required', 'date'],
            'hours' => ['nullable', 'numeric', 'min:0', 'max:24'],
            'notes' => ['required', 'string', 'max:1000'],
        ]);

        // Set default hours to 0 if not provided
        $data['hours'] = $data['hours'] ?? 0;

        $entry = DB::table('timesheet_entries')->where('id', $id)->first();
        if (!$entry) {
            return back()->with('error', 'Entry not found');
        }

        // Check if current user is main user
        $authUser = session('auth_user');
        $isMainUser = false;
        if ($authUser && isset($authUser['id'])) {
            $user = DB::table('users')->where('id', $authUser['id'])->first();
            $isMainUser = $user && $user->is_main_user == 1;
        }

        $timesheet = DB::table('timesheets')
            ->where('id', $entry->timesheet_id)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        // Only main user can edit other employees' entries
        // Regular users can only edit their own entries
        if (!$isMainUser && $timesheet->employee_id != $employeeId) {
            return back()->with('error', 'You do not have permission to edit this entry');
        }

        if (!in_array($timesheet->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Cannot edit timesheet after submission');
        }


        DB::table('timesheet_entries')
            ->where('id', $id)
            ->update([
                'project_id' => $data['project_id'] ?? null,
                'activity_name' => $data['activity_name'] ?? null,
                'work_date' => $data['work_date'],
                'hours' => $data['hours'],
                'notes' => $data['notes'] ?? null,
                'updated_at' => now(),
            ]);

        // Recalculate total hours
        $this->recalculateTotal($entry->timesheet_id);

        return redirect()->route('time.my-timesheets')->with('status', 'Entry updated successfully');
    }

    /**
     * Delete a timesheet entry.
     */
    public function deleteEntry(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $entry = DB::table('timesheet_entries')->where('id', $id)->first();
        if (!$entry) {
            return back()->with('error', 'Entry not found');
        }

        $timesheet = DB::table('timesheets')
            ->where('id', $entry->timesheet_id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if (!in_array($timesheet->status, ['draft', 'rejected'])) {
            return back()->with('error', 'Cannot delete entry after submission');
        }

        DB::table('timesheet_entries')->where('id', $id)->delete();

        // Recalculate total hours
        $this->recalculateTotal($entry->timesheet_id);

        return redirect()->route('time.my-timesheets')->with('status', 'Entry deleted successfully');
    }

    /**
     * Submit timesheet for approval.
     */
    public function submit(Request $request, int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $timesheet = DB::table('timesheets')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if ($timesheet->status !== 'draft') {
            return back()->with('error', 'Only draft timesheets can be submitted');
        }

        // Check if timesheet has entries
        $hasEntries = DB::table('timesheet_entries')
            ->where('timesheet_id', $id)
            ->exists();

        if (!$hasEntries) {
            return back()->with('error', 'Cannot submit timesheet without entries');
        }

        // Recalculate total hours before submission
        $this->recalculateTotal($id);

        DB::table('timesheets')
            ->where('id', $id)
            ->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()->route('time.my-timesheets')
            ->with('status', 'Timesheet submitted successfully');
    }

    /**
     * Recalculate total hours for a timesheet.
     */
    public function recalculateTotal(int $timesheetId)
    {
        $total = DB::table('timesheet_entries')
            ->where('timesheet_id', $timesheetId)
            ->sum('hours');

        DB::table('timesheets')
            ->where('id', $timesheetId)
            ->update(['total_hours' => $total]);

        return $total;
    }

    // ============================================
    // TIMESHEETS - Manager Methods
    // ============================================

    /**
     * Get list of pending timesheets for manager approval.
     */
    public function index(Request $request)
    {
        [$userId, $currentEmployeeId] = $this->resolveUserAndEmployee();

        // Get all timesheet entries for other employees (excluding logged-in user)
        $query = DB::table('timesheet_entries')
            ->join('timesheets', 'timesheet_entries.timesheet_id', '=', 'timesheets.id')
            ->join('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->where('timesheets.employee_id', '!=', $currentEmployeeId)
            ->select(
                'timesheet_entries.id',
                'timesheet_entries.timesheet_id',
                'timesheet_entries.project_id',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheet_entries.notes',
                'timesheet_entries.created_at',
                'employees.id as employee_id',
                'employees.display_name as employee_name',
                'time_projects.name as project_name'
            );

        // Filter by employee name
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->employee_name . '%');
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('timesheet_entries.work_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('timesheet_entries.work_date', '<=', $request->to_date);
        }

        $entries = $query->orderBy('timesheet_entries.work_date', 'desc')
            ->orderBy('timesheet_entries.created_at', 'desc')
            ->get();

        // Group entries by employee and date - only show latest entry per date per employee
        $groupedEntries = [];
        $entriesByEmployeeAndDate = [];
        
        foreach ($entries as $entry) {
            $key = $entry->employee_id . '_' . Carbon::parse($entry->work_date)->format('Y-m-d');
            
            // Keep only the latest entry for each employee-date combination
            if (!isset($entriesByEmployeeAndDate[$key]) || 
                Carbon::parse($entry->created_at)->gt(Carbon::parse($entriesByEmployeeAndDate[$key]->created_at))) {
                $entriesByEmployeeAndDate[$key] = $entry;
            }
        }
        
        // Convert to array format
        foreach ($entriesByEmployeeAndDate as $entry) {
            $groupedEntries[] = [
                'id' => $entry->id,
                'employee_id' => $entry->employee_id,
                'employee_name' => $entry->employee_name,
                'project_id' => $entry->project_id,
                'project_name' => $entry->project_name ?? '-',
                'activity_name' => $entry->activity_name ?? '-',
                'work_date' => $entry->work_date,
                'notes' => $entry->notes ?? '',
                'hours' => (float)$entry->hours,
            ];
        }
        
        // Sort by work_date descending (newest first)
        usort($groupedEntries, function($a, $b) {
            return strcmp($b['work_date'], $a['work_date']);
        });

        // Check if current user is main user
        $authUser = session('auth_user');
        $isMainUser = false;
        if ($authUser && isset($authUser['id'])) {
            $user = DB::table('users')->where('id', $authUser['id'])->first();
            $isMainUser = $user && $user->is_main_user == 1;
        }

        return view('time.time', [
            'groupedEntries' => $groupedEntries,
            'isMainUser' => $isMainUser,
        ]);
    }

    /**
     * View a specific timesheet for approval.
     */
    public function viewTimesheet(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $timesheet = DB::table('timesheets')
            ->join('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->leftJoin('users', 'employees.id', '=', 'users.employee_id')
            ->select(
                'timesheets.*',
                'employees.display_name as employee_name',
                'users.username'
            )
            ->where('timesheets.id', $id)
            ->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if ($timesheet->status !== 'submitted') {
            return back()->with('error', 'Timesheet is not pending approval');
        }

        // Get entries
        $entries = DB::table('timesheet_entries')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->where('timesheet_entries.timesheet_id', $id)
            ->select(
                'timesheet_entries.id',
                'timesheet_entries.project_id',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheet_entries.notes',
                'time_projects.name as project_name'
            )
            ->orderBy('timesheet_entries.work_date')
            ->orderBy('time_projects.name')
            ->get();

        $weekStart = Carbon::parse($timesheet->week_start_date ?? $timesheet->start_date);
        $weekEnd = Carbon::parse($timesheet->week_end_date ?? $timesheet->end_date);

        $days = [];
        $cursor = $weekStart->copy();
        while ($cursor->lte($weekEnd)) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day_of_month' => $cursor->format('d'),
                'day_name_short' => $cursor->format('D'),
            ];
            $cursor->addDay();
        }

        // Group entries
        $groupedEntries = [];
        foreach ($entries as $entry) {
            $key = ($entry->project_name ?? 'No Project') . '|' . ($entry->activity_name ?? '');
            if (!isset($groupedEntries[$key])) {
                $groupedEntries[$key] = [
                    'project_id' => $entry->project_id,
                    'project_name' => $entry->project_name ?? 'No Project',
                    'activity_name' => $entry->activity_name ?? '',
                    'hours' => array_fill(0, count($days), 0),
                    'total' => 0,
                ];
            }
            $dayIndex = Carbon::parse($entry->work_date)->diffInDays($weekStart);
            if ($dayIndex >= 0 && $dayIndex < count($days)) {
                $groupedEntries[$key]['hours'][$dayIndex] = (float)$entry->hours;
                $groupedEntries[$key]['total'] += (float)$entry->hours;
            }
        }

        return view('time.view-timesheet', [
            'timesheet' => $timesheet,
            'days' => $days,
            'groupedEntries' => array_values($groupedEntries),
        ]);
    }

    /**
     * Approve a timesheet.
     */
    public function approve(Request $request, int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $timesheet = DB::table('timesheets')->where('id', $id)->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if ($timesheet->status !== 'submitted') {
            return back()->with('error', 'Only submitted timesheets can be approved');
        }

        // Cannot approve own timesheet
        if ($timesheet->employee_id == $employeeId) {
            return back()->with('error', 'You cannot approve your own timesheet');
        }

        DB::table('timesheets')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'approved_by' => $employeeId,
                'approved_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()->route('time')
            ->with('status', 'Timesheet approved successfully');
    }

    /**
     * Reject a timesheet with reason.
     */
    public function reject(Request $request, int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:1000'],
        ]);

        $timesheet = DB::table('timesheets')->where('id', $id)->first();

        if (!$timesheet) {
            return back()->with('error', 'Timesheet not found');
        }

        if ($timesheet->status !== 'submitted') {
            return back()->with('error', 'Only submitted timesheets can be rejected');
        }

        // Cannot reject own timesheet
        if ($timesheet->employee_id == $employeeId) {
            return back()->with('error', 'You cannot reject your own timesheet');
        }

        DB::table('timesheets')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'rejected_by' => $employeeId,
                'rejected_at' => now(),
                'rejection_reason' => $data['rejection_reason'],
                'updated_at' => now(),
            ]);

        return redirect()->route('time')
            ->with('status', 'Timesheet rejected successfully');
    }

    // ============================================
    // ATTENDANCE Methods
    // ============================================

    /**
     * Punch In.
     */
    public function punchIn(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'date' => ['required', 'date'],
            'time' => ['required', 'string'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        // Check if employee can punch in (no open punch in and no completed entry for today)
        if (!AttendanceRecord::canPunchIn($employeeId)) {
            $completedEntry = AttendanceRecord::hasCompletedEntryToday($employeeId);
            if ($completedEntry) {
                return back()->with('error', 'You have already completed your attendance for today. You can punch in again tomorrow.');
            }
            return back()->with('error', 'You have an open punch in. Please punch out first.');
        }

        // Parse date and time
        $punchDateTime = Carbon::parse($data['date'] . ' ' . $data['time']);

        // Create attendance record
        $recordId = DB::table('attendance_records')->insertGetId([
            'employee_id' => $employeeId,
            'date' => $data['date'],
            'punch_in' => $punchDateTime,
            'punch_in_at' => $punchDateTime, // Keep for backward compatibility
            'punch_in_note' => $data['note'] ?? null,
            'remarks' => $data['note'] ?? null, // Keep for backward compatibility
            'punch_in_ip' => $request->ip(),
            'punch_in_source' => 'web',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('time.attendance.punch-in-out')
            ->with('status', 'Punched in successfully at ' . $punchDateTime->format('h:i A'));
    }

    /**
     * Punch Out.
     */
    public function punchOut(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $data = $request->validate([
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        // Get open punch in record
        $openRecord = AttendanceRecord::getOpenPunchIn($employeeId);

        if (!$openRecord) {
            return back()->with('error', 'No open punch in found. Please punch in first.');
        }

        // Use current India time
        $punchOutDateTime = Carbon::now('Asia/Kolkata');

        // Calculate duration
        $punchIn = Carbon::parse($openRecord->punch_in ?? $openRecord->punch_in_at);
        $duration = $punchIn->floatDiffInHours($punchOutDateTime);

        // Update attendance record
        DB::table('attendance_records')
            ->where('id', $openRecord->id)
            ->update([
                'punch_out' => $punchOutDateTime,
                'punch_out_at' => $punchOutDateTime, // Keep for backward compatibility
                'punch_out_note' => $data['note'] ?? null,
                'total_duration' => $duration,
                'punch_out_ip' => $request->ip(),
                'punch_out_source' => 'web',
                'updated_at' => now(),
            ]);

        return redirect()->route('time.attendance.punch-in-out')
            ->with('status', 'Punched out successfully. Duration: ' . number_format($duration, 2) . ' hours');
    }

    /**
     * Get my attendance records.
     */
    public function attendanceMyRecords(Request $request)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $today = Carbon::now('Asia/Kolkata');
        $selectedDate = $request->get('date', $today->format('Y-m-d'));

        $records = DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->where(function($q) use ($selectedDate) {
                $q->whereDate('date', $selectedDate)
                  ->orWhereDate('punch_in', $selectedDate)
                  ->orWhereDate('punch_in_at', $selectedDate);
            })
            ->orderBy('punch_in')
            ->orderBy('punch_in_at')
            ->get()
            ->map(function ($row) {
                $punchIn = $row->punch_in ?? $row->punch_in_at;
                $punchOut = $row->punch_out ?? $row->punch_out_at;
                
                $duration = 0;
                if ($punchIn && $punchOut) {
                    $duration = Carbon::parse($punchIn)->floatDiffInHours(Carbon::parse($punchOut));
                } elseif ($row->total_duration) {
                    $duration = (float)$row->total_duration;
                }

                return (object) [
                    'id' => $row->id,
                    'punch_in' => $punchIn ? Carbon::parse($punchIn)->format('Y-m-d h:i A') : null,
                    'punch_in_note' => $row->punch_in_note ?? $row->remarks,
                    'punch_out' => $punchOut ? Carbon::parse($punchOut)->format('Y-m-d h:i A') : null,
                    'punch_out_note' => $row->punch_out_note,
                    'duration' => $duration,
                ];
            });

        $totalDuration = $records->sum('duration');

        return view('time.attendance.my-records', [
            'selectedDate' => $selectedDate,
            'records' => $records,
            'totalDuration' => $totalDuration,
        ]);
    }

    /**
     * Calculate duration for a record.
     */
    public function calculateDuration(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $record = DB::table('attendance_records')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$record) {
            return back()->with('error', 'Record not found');
        }

        $punchIn = $record->punch_in ?? $record->punch_in_at;
        $punchOut = $record->punch_out ?? $record->punch_out_at;

        if (!$punchIn || !$punchOut) {
            return back()->with('error', 'Both punch in and punch out are required');
        }

        $duration = Carbon::parse($punchIn)->floatDiffInHours(Carbon::parse($punchOut));

        DB::table('attendance_records')
            ->where('id', $id)
            ->update(['total_duration' => $duration]);

        return back()->with('status', 'Duration calculated: ' . number_format($duration, 2) . ' hours');
    }

    /**
     * Delete attendance record.
     */
    public function deleteAttendanceRecord(int $id)
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $record = DB::table('attendance_records')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->first();

        if (!$record) {
            return back()->with('error', 'Record not found');
        }

        DB::table('attendance_records')
            ->where('id', $id)
            ->where('employee_id', $employeeId)
            ->delete();

        return back()->with('status', 'Attendance record deleted successfully');
    }

    /**
     * Get employee attendance records (Admin view).
     * Excludes current logged-in user.
     */
    public function attendanceEmployeeRecords(Request $request)
    {
        [$userId, $currentEmployeeId] = $this->resolveUserAndEmployee();
        
        $today = Carbon::now('Asia/Kolkata');
        $selectedDate = $request->get('date', $today->format('Y-m-d'));
        $employeeName = $request->get('employee_name', '');

        $query = DB::table('attendance_records')
            ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
            ->where('attendance_records.employee_id', '!=', $currentEmployeeId) // Exclude current logged-in user
            ->where(function($q) use ($selectedDate) {
                $q->whereDate('attendance_records.date', $selectedDate)
                  ->orWhereDate('attendance_records.punch_in', $selectedDate)
                  ->orWhereDate('attendance_records.punch_in_at', $selectedDate);
            })
            ->select(
                'attendance_records.id',
                'attendance_records.employee_id',
                'employees.display_name as employee_name',
                'attendance_records.punch_in',
                'attendance_records.punch_in_at',
                'attendance_records.punch_out',
                'attendance_records.punch_out_at',
                'attendance_records.total_duration'
            )
            ->orderBy('employees.display_name')
            ->orderBy('attendance_records.punch_in')
            ->orderBy('attendance_records.punch_in_at');

        if ($employeeName) {
            $query->where('employees.display_name', 'like', '%' . $employeeName . '%');
        }

        $rows = $query->get();

        $records = $rows->groupBy('employee_name')->map(function ($employeeRows, $name) {
            $total = 0;
            $sessions = [];
            
            foreach ($employeeRows as $row) {
                $punchIn = $row->punch_in ?? $row->punch_in_at;
                $punchOut = $row->punch_out ?? $row->punch_out_at;
                
                $duration = 0;
                if ($punchIn && $punchOut) {
                    $duration = Carbon::parse($punchIn)->floatDiffInHours(Carbon::parse($punchOut));
                } elseif ($row->total_duration) {
                    $duration = (float)$row->total_duration;
                }
                
                $total += $duration;
                $sessions[] = [
                    'punch_in' => $punchIn ? Carbon::parse($punchIn)->format('h:i A') : null,
                    'punch_out' => $punchOut ? Carbon::parse($punchOut)->format('h:i A') : null,
                    'duration' => $duration,
                ];
            }

            return (object) [
                'employee_name' => $name,
                'employee_id' => $employeeRows->first()->employee_id,
                'total_duration' => $total,
                'sessions' => $sessions,
            ];
        })->values();

        return view('time.attendance.employee-records', [
            'selectedDate' => $selectedDate,
            'employeeName' => $employeeName,
            'records' => $records,
        ]);
    }

    /**
     * View individual employee attendance records for a specific date.
     */
    public function viewEmployeeAttendanceRecords(Request $request, int $employeeId)
    {
        [$userId, $currentEmployeeId] = $this->resolveUserAndEmployee();
        
        // Ensure we're not viewing our own records
        if ($employeeId == $currentEmployeeId) {
            return back()->with('error', 'You cannot view your own records here. Use "My Records" instead.');
        }
        
        $today = Carbon::now('Asia/Kolkata');
        $selectedDate = $request->get('date', $today->format('Y-m-d'));

        $employee = DB::table('employees')->where('id', $employeeId)->first();
        if (!$employee) {
            return back()->with('error', 'Employee not found');
        }

        $records = DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->where(function($q) use ($selectedDate) {
                $q->whereDate('date', $selectedDate)
                  ->orWhereDate('punch_in', $selectedDate)
                  ->orWhereDate('punch_in_at', $selectedDate);
            })
            ->orderBy('punch_in')
            ->orderBy('punch_in_at')
            ->get()
            ->map(function ($row) {
                $punchIn = $row->punch_in ?? $row->punch_in_at;
                $punchOut = $row->punch_out ?? $row->punch_out_at;
                
                $duration = 0;
                if ($punchIn && $punchOut) {
                    $duration = Carbon::parse($punchIn)->floatDiffInHours(Carbon::parse($punchOut));
                } elseif ($row->total_duration) {
                    $duration = (float)$row->total_duration;
                }

                return (object) [
                    'id' => $row->id,
                    'punch_in' => $punchIn ? Carbon::parse($punchIn)->format('Y-m-d h:i A') : null,
                    'punch_in_note' => $row->punch_in_note ?? $row->remarks,
                    'punch_out' => $punchOut ? Carbon::parse($punchOut)->format('Y-m-d h:i A') : null,
                    'punch_out_note' => $row->punch_out_note,
                    'duration' => $duration,
                ];
            });

        $totalDuration = $records->sum('duration');
        $employeeName = $employee->display_name ?? $employee->first_name . ' ' . $employee->last_name;

        return view('time.attendance.view-employee-records', [
            'selectedDate' => $selectedDate,
            'employeeId' => $employeeId,
            'employeeName' => $employeeName,
            'records' => $records,
            'totalDuration' => $totalDuration,
        ]);
    }

    /**
     * Attendance - Punch In/Out (View)
     */
    public function attendancePunchInOut()
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();
        
        // Set timezone to India
        $now = Carbon::now('Asia/Kolkata');
        $currentDate = $now->format('Y-m-d');
        $currentTime = $now->format('h:i A'); // 12-hour format with AM/PM
        
        // Check if employee has an open punch in
        $openPunchIn = AttendanceRecord::getOpenPunchIn($employeeId);
        
        // Check if employee has a completed entry for today
        $completedEntry = AttendanceRecord::hasCompletedEntryToday($employeeId);
        
        return view('time.attendance.punch-in-out', [
            'currentDate' => $currentDate,
            'currentTime' => $currentTime,
            'hasOpenPunchIn' => $openPunchIn !== null,
            'openPunchIn' => $openPunchIn,
            'hasCompletedEntryToday' => $completedEntry !== null,
            'completedEntry' => $completedEntry,
        ]);
    }

    /**
     * Attendance - Configuration
     */
    public function attendanceConfiguration()
    {
        return view('time.attendance.configuration');
    }

    // ============================================
    // REPORTS Methods
    // ============================================

    /**
     * Project Report.
     */
    public function projectReports(Request $request)
    {
        $data = $request->validate([
            'project_name' => ['nullable', 'string', 'max:255'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'only_approved' => ['nullable', 'boolean'],
        ]);

        $query = DB::table('timesheet_entries')
            ->join('timesheets', 'timesheet_entries.timesheet_id', '=', 'timesheets.id')
            ->join('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->select(
                'employees.display_name as employee_name',
                'time_projects.name as project_name',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheets.status'
            );

        // Filter by project name
        if ($request->filled('project_name')) {
            $query->where('time_projects.name', 'like', '%' . $request->project_name . '%');
        }

        // Filter by date range
        if ($request->filled('from_date')) {
            $query->where('timesheet_entries.work_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('timesheet_entries.work_date', '<=', $request->to_date);
        }

        // Filter by approved timesheets only
        if ($request->has('only_approved') && $request->only_approved) {
            $query->where('timesheets.status', 'approved');
        }

        $entries = $query->orderBy('employees.display_name')
            ->orderBy('time_projects.name')
            ->orderBy('timesheet_entries.work_date')
            ->get();

        // Group by employee and project
        $grouped = [];
        foreach ($entries as $entry) {
            $key = $entry->employee_name . '|' . ($entry->project_name ?? 'No Project');
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'employee_name' => $entry->employee_name,
                    'project_name' => $entry->project_name ?? 'No Project',
                    'activities' => [],
                    'total_hours' => 0,
                ];
            }

            $activityKey = $entry->activity_name ?? 'General';
            if (!isset($grouped[$key]['activities'][$activityKey])) {
                $grouped[$key]['activities'][$activityKey] = 0;
            }

            $grouped[$key]['activities'][$activityKey] += (float)$entry->hours;
            $grouped[$key]['total_hours'] += (float)$entry->hours;
        }

        $results = array_values($grouped);

        return view('time.reports.project-reports', [
            'results' => $results,
            'filters' => $data,
        ]);
    }

    /**
     * Employee Report.
     */
    public function employeeReports(Request $request)
    {
        $data = $request->validate([
            'employee_name' => ['nullable', 'string', 'max:255'],
            'project' => ['nullable', 'string', 'max:255'],
            'activity' => ['nullable', 'string', 'max:255'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
            'only_approved' => ['nullable', 'boolean'],
        ]);

        $query = DB::table('timesheet_entries')
            ->join('timesheets', 'timesheet_entries.timesheet_id', '=', 'timesheets.id')
            ->join('employees', 'timesheets.employee_id', '=', 'employees.id')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->select(
                'timesheets.id as timesheet_id',
                'timesheets.week_start_date',
                'timesheets.week_end_date',
                'timesheets.start_date',
                'timesheets.end_date',
                'employees.display_name as employee_name',
                'time_projects.name as project_name',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheets.status'
            );

        // Filters
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->employee_name . '%');
        }
        if ($request->filled('project')) {
            $query->where('time_projects.name', 'like', '%' . $request->project . '%');
        }
        if ($request->filled('activity')) {
            $query->where('timesheet_entries.activity_name', 'like', '%' . $request->activity . '%');
        }
        if ($request->filled('from_date')) {
            $query->where('timesheet_entries.work_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->where('timesheet_entries.work_date', '<=', $request->to_date);
        }
        if ($request->has('only_approved') && $request->only_approved) {
            $query->where('timesheets.status', 'approved');
        }

        $entries = $query->orderBy('employees.display_name')
            ->orderBy('timesheet_entries.work_date')
            ->get();

        // Group by employee and project
        $grouped = [];
        foreach ($entries as $entry) {
            $employeeKey = $entry->employee_name;
            if (!isset($grouped[$employeeKey])) {
                $grouped[$employeeKey] = [
                    'employee_name' => $entry->employee_name,
                    'projects' => [],
                    'total_hours' => 0,
                    'weekly_breakdown' => [],
                ];
            }

            $projectKey = $entry->project_name ?? 'No Project';
            if (!isset($grouped[$employeeKey]['projects'][$projectKey])) {
                $grouped[$employeeKey]['projects'][$projectKey] = 0;
            }

            $grouped[$employeeKey]['projects'][$projectKey] += (float)$entry->hours;
            $grouped[$employeeKey]['total_hours'] += (float)$entry->hours;

            // Weekly breakdown
            $weekStart = Carbon::parse($entry->week_start_date ?? $entry->start_date)->format('Y-m-d');
            if (!isset($grouped[$employeeKey]['weekly_breakdown'][$weekStart])) {
                $grouped[$employeeKey]['weekly_breakdown'][$weekStart] = 0;
            }
            $grouped[$employeeKey]['weekly_breakdown'][$weekStart] += (float)$entry->hours;
        }

        // Convert to array format
        $results = [];
        foreach ($grouped as $employee) {
            $results[] = [
                'employee_name' => $employee['employee_name'],
                'projects' => $employee['projects'],
                'total_hours' => $employee['total_hours'],
                'weekly_breakdown' => $employee['weekly_breakdown'],
            ];
        }

        return view('time.reports.employee-reports', [
            'results' => $results,
            'filters' => $data,
        ]);
    }

    /**
     * Attendance Summary Report.
     */
    public function attendanceSummary(Request $request)
    {
        $data = $request->validate([
            'employee_name' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'sub_unit' => ['nullable', 'string', 'max:255'],
            'from_date' => ['nullable', 'date'],
            'to_date' => ['nullable', 'date'],
        ]);

        $query = DB::table('attendance_records')
            ->join('employees', 'attendance_records.employee_id', '=', 'employees.id')
            ->leftJoin('job_titles', 'employees.job_title_id', '=', 'job_titles.id')
            ->leftJoin('organization_units', 'employees.organization_unit_id', '=', 'organization_units.id')
            ->select(
                'employees.id as employee_id',
                'employees.display_name as employee_name',
                'job_titles.name as job_title',
                'organization_units.name as sub_unit',
                'attendance_records.date',
                'attendance_records.punch_in',
                'attendance_records.punch_in_at',
                'attendance_records.punch_out',
                'attendance_records.punch_out_at',
                'attendance_records.total_duration'
            );

        // Filters
        if ($request->filled('employee_name')) {
            $query->where('employees.display_name', 'like', '%' . $request->employee_name . '%');
        }
        if ($request->filled('job_title')) {
            $query->where('job_titles.name', 'like', '%' . $request->job_title . '%');
        }
        if ($request->filled('sub_unit')) {
            $query->where('organization_units.name', 'like', '%' . $request->sub_unit . '%');
        }
        if ($request->filled('from_date')) {
            $query->where(function($q) use ($request) {
                $q->whereDate('attendance_records.date', '>=', $request->from_date)
                  ->orWhereDate('attendance_records.punch_in_at', '>=', $request->from_date);
            });
        }
        if ($request->filled('to_date')) {
            $query->where(function($q) use ($request) {
                $q->whereDate('attendance_records.date', '<=', $request->to_date)
                  ->orWhereDate('attendance_records.punch_in_at', '<=', $request->to_date);
            });
        }

        $records = $query->get();

        // Group by employee
        $grouped = [];
        foreach ($records as $record) {
            $key = $record->employee_id;
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'employee_id' => $record->employee_id,
                    'employee_name' => $record->employee_name,
                    'job_title' => $record->job_title,
                    'sub_unit' => $record->sub_unit,
                    'total_attendance_hours' => 0,
                    'total_days_present' => 0,
                    'late_count' => 0,
                    'absent_count' => 0,
                ];
            }

            $punchIn = $record->punch_in ?? $record->punch_in_at;
            $punchOut = $record->punch_out ?? $record->punch_out_at;

            if ($punchIn) {
                $grouped[$key]['total_days_present']++;
                
                if ($punchOut || $record->total_duration) {
                    $duration = 0;
                    if ($punchIn && $punchOut) {
                        $duration = Carbon::parse($punchIn)->floatDiffInHours(Carbon::parse($punchOut));
                    } elseif ($record->total_duration) {
                        $duration = (float)$record->total_duration;
                    }
                    $grouped[$key]['total_attendance_hours'] += $duration;
                }
            }
        }

        $results = array_values($grouped);

        // Get job titles for dropdown
        $jobTitles = DB::table('job_titles')->select('id', 'name')->orderBy('name')->get();

        return view('time.reports.attendance-summary', [
            'results' => $results,
            'filters' => $data,
            'jobTitles' => $jobTitles,
        ]);
    }

    // ============================================
    // LEGACY METHODS (Keep for backward compatibility)
    // ============================================

    public function editMyTimesheet()
    {
        [$userId, $employeeId] = $this->resolveUserAndEmployee();

        $timesheet = $this->getOrCreateCurrentWeekTimesheet($employeeId);

        $weekStart = Carbon::parse($timesheet->week_start_date ?? $timesheet->start_date);
        $weekEnd = Carbon::parse($timesheet->week_end_date ?? $timesheet->end_date);

        $days = [];
        $cursor = $weekStart->copy();
        while ($cursor->lte($weekEnd)) {
            $days[] = [
                'date' => $cursor->toDateString(),
                'day_of_month' => $cursor->format('d'),
                'day_name_short' => $cursor->format('D'),
            ];
            $cursor->addDay();
        }

        $timesheetPeriod = [
            'start' => $weekStart->toDateString(),
            'end' => $weekEnd->toDateString(),
        ];

        // Get all entries for this timesheet
        $entries = DB::table('timesheet_entries')
            ->leftJoin('time_projects', 'timesheet_entries.project_id', '=', 'time_projects.id')
            ->where('timesheet_entries.timesheet_id', $timesheet->id)
            ->select(
                'timesheet_entries.id',
                'timesheet_entries.project_id',
                'timesheet_entries.activity_name',
                'timesheet_entries.work_date',
                'timesheet_entries.hours',
                'timesheet_entries.notes',
                'time_projects.name as project_name'
            )
            ->orderBy('timesheet_entries.work_date', 'desc')
            ->orderBy('timesheet_entries.created_at', 'desc')
            ->get();

        // Get projects for dropdown
        $projects = DB::table('time_projects')
            ->where('is_active', 1)
            ->orderBy('name')
            ->get();

        // Check if there's an entry for today
        $todayEntry = DB::table('timesheet_entries')
            ->where('timesheet_id', $timesheet->id)
            ->whereDate('work_date', Carbon::now()->toDateString())
            ->orderBy('created_at', 'desc')
            ->first();

        return view('time.edit-my-timesheet', [
            'timesheet' => $timesheet,
            'days' => $days,
            'timesheetPeriod' => $timesheetPeriod,
            'entries' => $entries,
            'projects' => $projects,
            'todayEntry' => $todayEntry,
        ]);
    }

    // ============================================
    // PROJECT INFO Methods (Keep existing)
    // ============================================

    /**
     * Project Info - Customers
     */
    public function projectInfoCustomers()
    {
        $customers = DB::table('time_customers')
            ->select('id', 'name', 'description')
            ->orderBy('name')
            ->get();

        return view('time.project-info.customers', compact('customers'));
    }

    /**
     * Store a new customer.
     */
    public function storeCustomer(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::table('time_customers')->insert([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer added.');
    }

    /**
     * Update an existing customer.
     */
    public function updateCustomer(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        DB::table('time_customers')
            ->where('id', $id)
            ->update([
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer updated.');
    }

    /**
     * Delete a customer from the database.
     */
    public function deleteCustomer(int $id)
    {
        DB::table('time_customers')
            ->where('id', $id)
            ->delete();

        return redirect()->route('time.project-info.customers')
            ->with('status', 'Customer deleted.');
    }

    /**
     * Bulk delete customers from the database.
     */
    public function bulkDeleteCustomers(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->toArray();

        if (count($ids) > 0) {
            DB::table('time_customers')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('time.project-info.customers')
            ->with('status', count($ids) . ' customer(s) deleted.');
    }

    /**
     * Project Info - Projects
     */
    public function projectInfoProject(Request $request)
    {
        $query = DB::table('time_projects')
            ->leftJoin('time_customers', 'time_projects.customer_id', '=', 'time_customers.id')
            ->leftJoin('time_project_assignments', 'time_projects.id', '=', 'time_project_assignments.project_id')
            ->leftJoin('employees', 'time_project_assignments.employee_id', '=', 'employees.id')
            ->select(
                'time_projects.id',
                'time_projects.customer_id',
                'time_projects.name as project_name',
                'time_projects.description',
                'time_customers.name as customer_name',
                DB::raw("GROUP_CONCAT(DISTINCT employees.display_name ORDER BY employees.display_name SEPARATOR ', ') as admins")
            )
            ->groupBy('time_projects.id', 'time_projects.customer_id', 'time_projects.name', 'time_projects.description', 'time_customers.name');

        // Apply filters
        if ($request->filled('customer_name')) {
            $query->where('time_customers.name', 'like', '%' . $request->customer_name . '%');
        }

        if ($request->filled('project')) {
            $query->where('time_projects.name', 'like', '%' . $request->project . '%');
        }

        if ($request->filled('project_admin')) {
            $query->havingRaw("GROUP_CONCAT(DISTINCT employees.display_name ORDER BY employees.display_name SEPARATOR ', ') LIKE ?", ['%' . $request->project_admin . '%']);
        }

        $projects = $query->orderBy('time_projects.name')->get();

        // Get customers for dropdown
        $customers = DB::table('time_customers')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        // Get employees for dropdown
        $employees = DB::table('employees')
            ->select('id', 'display_name', 'first_name', 'last_name')
            ->orderBy('display_name')
            ->get();

        // Get current project admins for editing
        $projectAdmins = [];
        $adminAssignments = DB::table('time_project_assignments')
            ->where('role', 'Project Admin')
            ->get();
        
        foreach ($adminAssignments as $assignment) {
            $projectAdmins[$assignment->project_id] = $assignment->employee_id;
        }

        return view('time.project-info.projects', compact('projects', 'customers', 'employees', 'projectAdmins'));
    }

    /**
     * Store a new project.
     */
    public function storeProject(Request $request)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:time_customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'project_admin_id' => ['nullable', 'exists:employees,id'],
        ]);

        // Insert project
        $projectId = DB::table('time_projects')->insertGetId([
            'customer_id' => $data['customer_id'] ?? null,
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign project admin if selected
        if (!empty($data['project_admin_id'])) {
            DB::table('time_project_assignments')->insert([
                'project_id' => $projectId,
                'employee_id' => $data['project_admin_id'],
                'role' => 'Project Admin',
                'created_at' => now(),
            ]);
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project added.');
    }

    /**
     * Update an existing project.
     */
    public function updateProject(Request $request, int $id)
    {
        $data = $request->validate([
            'customer_id' => ['nullable', 'exists:time_customers,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:500'],
            'project_admin_id' => ['nullable', 'exists:employees,id'],
        ]);

        // Update project
        DB::table('time_projects')
            ->where('id', $id)
            ->update([
                'customer_id' => $data['customer_id'] ?? null,
                'name' => $data['name'],
                'description' => $data['description'] ?? null,
                'updated_at' => now(),
            ]);

        // Remove existing project admin assignments
        DB::table('time_project_assignments')
            ->where('project_id', $id)
            ->where('role', 'Project Admin')
            ->delete();

        // Assign new project admin if selected
        if (!empty($data['project_admin_id'])) {
            // Check if assignment already exists with different role
            $existingAssignment = DB::table('time_project_assignments')
                ->where('project_id', $id)
                ->where('employee_id', $data['project_admin_id'])
                ->first();

            if ($existingAssignment) {
                // Update existing assignment to Project Admin role
                DB::table('time_project_assignments')
                    ->where('project_id', $id)
                    ->where('employee_id', $data['project_admin_id'])
                    ->update([
                        'role' => 'Project Admin',
                        'updated_at' => now(),
                    ]);
            } else {
                // Insert new assignment
                DB::table('time_project_assignments')->insert([
                    'project_id' => $id,
                    'employee_id' => $data['project_admin_id'],
                    'role' => 'Project Admin',
                    'created_at' => now(),
                ]);
            }
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project updated.');
    }

    /**
     * Delete a project from the database.
     */
    public function deleteProject(int $id)
    {
        DB::table('time_projects')
            ->where('id', $id)
            ->delete();

        return redirect()->route('time.project-info.projects')
            ->with('status', 'Project deleted.');
    }

    /**
     * Bulk delete projects from the database.
     */
    public function bulkDeleteProjects(Request $request)
    {
        $idsParam = $request->input('ids', '');
        $ids = collect(explode(',', $idsParam))
            ->map(fn ($v) => (int) trim($v))
            ->filter(fn ($v) => $v > 0)
            ->unique()
            ->values()
            ->toArray();

        if (count($ids) > 0) {
            DB::table('time_projects')
                ->whereIn('id', $ids)
                ->delete();
        }

        return redirect()->route('time.project-info.projects')
            ->with('status', count($ids) . ' project(s) deleted.');
    }
}
