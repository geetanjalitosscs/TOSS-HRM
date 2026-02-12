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
        // Only add the column if the table exists and the column doesn't.
        if (Schema::hasTable('employees') && ! Schema::hasColumn('employees', 'photo_path')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->string('photo_path', 255)->nullable()->after('id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('employees') && Schema::hasColumn('employees', 'photo_path')) {
            Schema::table('employees', function (Blueprint $table) {
                $table->dropColumn('photo_path');
            });
        }
    }
};
