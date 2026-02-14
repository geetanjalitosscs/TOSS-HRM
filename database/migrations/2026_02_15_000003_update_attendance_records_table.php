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
        if (Schema::hasTable('attendance_records')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('attendance_records', 'date')) {
                    $table->date('date')->nullable()->after('employee_id');
                }
                if (!Schema::hasColumn('attendance_records', 'punch_in')) {
                    $table->datetime('punch_in')->nullable()->after('date');
                }
                if (!Schema::hasColumn('attendance_records', 'punch_out')) {
                    $table->datetime('punch_out')->nullable()->after('punch_in');
                }
                if (!Schema::hasColumn('attendance_records', 'punch_in_note')) {
                    $table->text('punch_in_note')->nullable()->after('punch_out');
                }
                if (!Schema::hasColumn('attendance_records', 'punch_out_note')) {
                    $table->text('punch_out_note')->nullable()->after('punch_in_note');
                }
                if (!Schema::hasColumn('attendance_records', 'total_duration')) {
                    $table->decimal('total_duration', 8, 2)->nullable()->after('punch_out_note');
                }
            });

            // Migrate existing data
            DB::statement("UPDATE attendance_records SET date = DATE(punch_in_at) WHERE date IS NULL");
            DB::statement("UPDATE attendance_records SET punch_in = punch_in_at WHERE punch_in IS NULL");
            DB::statement("UPDATE attendance_records SET punch_out = punch_out_at WHERE punch_out IS NULL AND punch_out_at IS NOT NULL");
            DB::statement("UPDATE attendance_records SET punch_in_note = remarks WHERE punch_in_note IS NULL AND remarks IS NOT NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('attendance_records')) {
            Schema::table('attendance_records', function (Blueprint $table) {
                $table->dropColumn([
                    'date',
                    'punch_in',
                    'punch_out',
                    'punch_in_note',
                    'punch_out_note',
                    'total_duration'
                ]);
            });
        }
    }
};

