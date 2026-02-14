<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AttendanceRecord extends Model
{
    protected $table = 'attendance_records';
    
    protected $fillable = [
        'employee_id',
        'date',
        'punch_in',
        'punch_out',
        'punch_in_note',
        'punch_out_note',
        'total_duration',
        'punch_in_at',
        'punch_out_at',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'punch_in' => 'datetime',
        'punch_out' => 'datetime',
        'punch_in_at' => 'datetime',
        'punch_out_at' => 'datetime',
        'total_duration' => 'decimal:2',
    ];

    /**
     * Get the employee that owns this record.
     */
    public function employee()
    {
        return DB::table('employees')->where('id', $this->employee_id)->first();
    }

    /**
     * Calculate duration between punch in and punch out.
     */
    public function calculateDuration()
    {
        if (!$this->punch_in || !$this->punch_out) {
            return 0;
        }

        $punchIn = Carbon::parse($this->punch_in);
        $punchOut = Carbon::parse($this->punch_out);
        
        $duration = $punchIn->floatDiffInHours($punchOut);
        
        DB::table('attendance_records')
            ->where('id', $this->id)
            ->update(['total_duration' => $duration]);

        $this->total_duration = $duration;
        return $duration;
    }

    /**
     * Check if employee can punch in (no open punch in without punch out).
     * Also checks if there's already a completed entry for today.
     * Only checks for today's records.
     */
    public static function canPunchIn($employeeId)
    {
        $today = Carbon::now('Asia/Kolkata')->format('Y-m-d');
        
        // Check for open punch in (no punch out)
        $openRecord = DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->whereNull('punch_out')
            ->whereNull('punch_out_at')
            ->where(function($query) use ($today) {
                $query->whereDate('date', $today)
                      ->orWhereDate('punch_in', $today)
                      ->orWhereDate('punch_in_at', $today);
            })
            ->first();

        if ($openRecord) {
            return false; // Has open punch in
        }

        // Check if there's already a completed entry (both punch_in and punch_out) for today
        $completedRecord = DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->whereNotNull('punch_out')
            ->where(function($query) use ($today) {
                $query->whereDate('date', $today)
                      ->orWhereDate('punch_in', $today)
                      ->orWhereDate('punch_in_at', $today);
            })
            ->first();

        return !$completedRecord; // Can punch in only if no completed entry for today
    }

    /**
     * Check if employee has a completed entry for today (both punch in and punch out).
     */
    public static function hasCompletedEntryToday($employeeId)
    {
        $today = Carbon::now('Asia/Kolkata')->format('Y-m-d');
        
        return DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->whereNotNull('punch_out')
            ->where(function($query) use ($today) {
                $query->whereDate('date', $today)
                      ->orWhereDate('punch_in', $today)
                      ->orWhereDate('punch_in_at', $today);
            })
            ->first();
    }

    /**
     * Get open punch in record for employee.
     * Only checks for today's records to avoid old incomplete records blocking new punch ins.
     */
    public static function getOpenPunchIn($employeeId)
    {
        $today = Carbon::now('Asia/Kolkata')->format('Y-m-d');
        
        return DB::table('attendance_records')
            ->where('employee_id', $employeeId)
            ->whereNull('punch_out')
            ->whereNull('punch_out_at')
            ->where(function($query) use ($today) {
                $query->whereDate('date', $today)
                      ->orWhereDate('punch_in', $today)
                      ->orWhereDate('punch_in_at', $today);
            })
            ->orderByDesc('punch_in')
            ->orderByDesc('punch_in_at')
            ->first();
    }
}

