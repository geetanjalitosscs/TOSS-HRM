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
        // Be defensive: only add the column if the table exists and the column is missing.
        if (Schema::hasTable('users') && ! Schema::hasColumn('users', 'page_permissions')) {
            Schema::table('users', function (Blueprint $table) {
                // Some existing databases may not have a 'created_by' column on users.
                // In that case, just append the column at the end instead of using ->after().
                if (Schema::hasColumn('users', 'created_by')) {
                    $table->json('page_permissions')->nullable()->after('created_by');
                } else {
                    $table->json('page_permissions')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'page_permissions')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('page_permissions');
            });
        }
    }
};

