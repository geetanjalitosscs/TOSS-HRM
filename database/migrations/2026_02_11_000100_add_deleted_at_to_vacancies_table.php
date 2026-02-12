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
        // Add soft delete column only if the table exists and column is missing
        if (Schema::hasTable('vacancies') && ! Schema::hasColumn('vacancies', 'deleted_at')) {
            Schema::table('vacancies', function (Blueprint $table) {
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('vacancies') && Schema::hasColumn('vacancies', 'deleted_at')) {
            Schema::table('vacancies', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};


