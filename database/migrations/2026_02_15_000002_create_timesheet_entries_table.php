<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create timesheet_entries table (new structure)
        if (!Schema::hasTable('timesheet_entries')) {
            Schema::create('timesheet_entries', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('timesheet_id');
                $table->unsignedBigInteger('project_id')->nullable();
                $table->string('activity_name', 255)->nullable();
                $table->date('work_date');
                $table->decimal('hours', 5, 2)->default(0.00);
                $table->text('notes')->nullable();
                $table->timestamps();

                $table->foreign('timesheet_id')->references('id')->on('timesheets')->onDelete('cascade');
                $table->foreign('project_id')->references('id')->on('time_projects')->onDelete('set null');
                $table->index(['timesheet_id', 'work_date']);
            });
        }

        // Migrate data from timesheet_rows to timesheet_entries if timesheet_rows exists
        if (Schema::hasTable('timesheet_rows')) {
            DB::statement("
                INSERT INTO timesheet_entries (timesheet_id, project_id, activity_name, work_date, hours, notes, created_at, updated_at)
                SELECT 
                    timesheet_id,
                    project_id,
                    NULL as activity_name,
                    work_date,
                    hours_worked as hours,
                    notes,
                    created_at,
                    updated_at
                FROM timesheet_rows
                WHERE NOT EXISTS (
                    SELECT 1 FROM timesheet_entries te 
                    WHERE te.timesheet_id = timesheet_rows.timesheet_id 
                    AND te.work_date = timesheet_rows.work_date
                )
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timesheet_entries');
    }
};

