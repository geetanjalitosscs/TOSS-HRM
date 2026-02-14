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
        if (Schema::hasTable('timesheets')) {
            Schema::table('timesheets', function (Blueprint $table) {
                // Add new columns if they don't exist
                if (!Schema::hasColumn('timesheets', 'week_start_date')) {
                    $table->date('week_start_date')->nullable()->after('employee_id');
                }
                if (!Schema::hasColumn('timesheets', 'week_end_date')) {
                    $table->date('week_end_date')->nullable()->after('week_start_date');
                }
                if (!Schema::hasColumn('timesheets', 'total_hours')) {
                    $table->decimal('total_hours', 8, 2)->default(0.00)->after('status');
                }
                if (!Schema::hasColumn('timesheets', 'rejected_at')) {
                    $table->datetime('rejected_at')->nullable()->after('approved_at');
                }
                if (!Schema::hasColumn('timesheets', 'rejected_by')) {
                    $table->unsignedBigInteger('rejected_by')->nullable()->after('rejected_at');
                }
                if (!Schema::hasColumn('timesheets', 'rejection_reason')) {
                    $table->text('rejection_reason')->nullable()->after('rejected_by');
                }
                
                // Update status enum if needed (only if column exists)
                if (Schema::hasColumn('timesheets', 'status')) {
                    try {
                        DB::statement("ALTER TABLE timesheets MODIFY COLUMN status ENUM('draft','submitted','approved','rejected') DEFAULT 'draft'");
                    } catch (\Exception $e) {
                        // Ignore if enum already exists or column doesn't support modification
                    }
                }
            });

            // Migrate existing data: copy start_date to week_start_date and end_date to week_end_date
            DB::statement("UPDATE timesheets SET week_start_date = start_date WHERE week_start_date IS NULL");
            DB::statement("UPDATE timesheets SET week_end_date = end_date WHERE week_end_date IS NULL");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('timesheets')) {
            Schema::table('timesheets', function (Blueprint $table) {
                $table->dropColumn([
                    'week_start_date',
                    'week_end_date',
                    'total_hours',
                    'rejected_at',
                    'rejected_by',
                    'rejection_reason'
                ]);
            });
        }
    }
};

