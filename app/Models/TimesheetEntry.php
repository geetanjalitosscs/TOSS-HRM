<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TimesheetEntry extends Model
{
    protected $table = 'timesheet_entries';
    
    protected $fillable = [
        'timesheet_id',
        'project_id',
        'activity_name',
        'work_date',
        'hours',
        'notes',
    ];

    protected $casts = [
        'work_date' => 'date',
        'hours' => 'decimal:2',
    ];

    /**
     * Get the timesheet that owns this entry.
     */
    public function timesheet()
    {
        return DB::table('timesheets')->where('id', $this->timesheet_id)->first();
    }

    /**
     * Get the project.
     */
    public function project()
    {
        if (!$this->project_id) {
            return null;
        }
        return DB::table('time_projects')->where('id', $this->project_id)->first();
    }
}

