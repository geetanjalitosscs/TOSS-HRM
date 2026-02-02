<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update existing employees with NULL display_name
        DB::statement("
            UPDATE employees 
            SET display_name = TRIM(CONCAT(
                COALESCE(first_name, ''), ' ',
                COALESCE(middle_name, ''), ' ',
                COALESCE(last_name, '')
            ))
            WHERE display_name IS NULL OR display_name = ''
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration is not reversible as we don't know the original NULL values
        // However, we could set all display_names back to NULL if needed
        // DB::statement("UPDATE employees SET display_name = NULL");
    }
};
