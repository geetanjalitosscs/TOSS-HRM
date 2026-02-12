<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add email column only if table exists and column is missing
        if (Schema::hasTable('employee_emergency_contacts') && ! Schema::hasColumn('employee_emergency_contacts', 'email')) {
            Schema::table('employee_emergency_contacts', function (Blueprint $table) {
                $table->string('email', 191)->nullable()->after('work_phone');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('employee_emergency_contacts') && Schema::hasColumn('employee_emergency_contacts', 'email')) {
            Schema::table('employee_emergency_contacts', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};


