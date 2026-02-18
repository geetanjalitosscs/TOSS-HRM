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
        Schema::table('time_projects', function (Blueprint $table) {
            if (!Schema::hasColumn('time_projects', 'start_date')) {
                $table->date('start_date')->nullable()->after('description');
            }
            if (!Schema::hasColumn('time_projects', 'end_date')) {
                $table->date('end_date')->nullable()->after('start_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('time_projects', function (Blueprint $table) {
            if (Schema::hasColumn('time_projects', 'start_date')) {
                $table->dropColumn('start_date');
            }
            if (Schema::hasColumn('time_projects', 'end_date')) {
                $table->dropColumn('end_date');
            }
        });
    }
};
