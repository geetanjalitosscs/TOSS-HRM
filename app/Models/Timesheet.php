<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Timesheet extends Model
{
    protected $table = 'timesheets';
    
    protected $fillable = [
        'employee_id',
        'week_start_date',
        'week_end_date',
        'start_date',
        'end_date',
        'status',
        'submitted_at',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'total_hours',
        'remarks',
    ];

    protected $casts = [
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'start_date' => 'date',
        'end_date' => 'date',
        'submitted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'total_hours' => 'decimal:2',
    ];

    /**
     * Get the employee that owns the timesheet.
     */
    public function employee()
    {
        return DB::table('employees')->where('id', $this->employee_id)->first();
    }

    /**
     * Get the approver employee.
     */
    public function approver()
    {
        if (!$this->approved_by) {
            return null;
        }
        return DB::table('employees')->where('id', $this->approved_by)->first();
    }

    /**
     * Get the rejector employee.
     */
    public function rejector()
    {
        if (!$this->rejected_by) {
            return null;
        }
        return DB::table('employees')->where('id', $this->rejected_by)->first();
    }

    /**
     * Get all entries for this timesheet.
     */
    public function entries()
    {
        return DB::table('timesheet_entries')
            ->where('timesheet_id', $this->id)
            ->orderBy('work_date')
            ->orderBy('project_id')
            ->get();
    }

    /**
     * Check if timesheet can be edited.
     */
    public function canEdit()
    {
        return in_array($this->status, ['draft', 'rejected']);
    }

    /**
     * Check if timesheet can be submitted.
     */
    public function canSubmit()
    {
        return $this->status === 'draft' && $this->hasEntries();
    }

    /**
     * Check if timesheet has entries.
     */
    public function hasEntries()
    {
        return DB::table('timesheet_entries')
            ->where('timesheet_id', $this->id)
            ->exists();
    }

    /**
     * Recalculate total hours from entries.
     */
    public function recalculateTotal()
    {
        $total = DB::table('timesheet_entries')
            ->where('timesheet_id', $this->id)
            ->sum('hours');

        DB::table('timesheets')
            ->where('id', $this->id)
            ->update(['total_hours' => $total]);

        $this->total_hours = $total;
        return $total;
    }
}

