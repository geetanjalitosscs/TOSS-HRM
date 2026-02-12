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
        // Create the table only if it doesn't already exist
        if (! Schema::hasTable('theme_colors')) {
            Schema::create('theme_colors', function (Blueprint $table) {
                $table->id();
                $table->string('variable_name', 100); // e.g., '--color-primary', '--bg-main'
                $table->string('display_name', 200); // e.g., 'Primary Color', 'Main Background'
                $table->string('category', 50); // e.g., 'primary', 'background', 'text', 'border', 'shadow', 'scrollbar'
                $table->string('theme', 20)->default('light'); // 'light' or 'dark'
                $table->string('color_value', 50); // Hex color or rgba value
                $table->text('description')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
                
                // Unique constraint on variable_name + theme combination
                $table->unique(['variable_name', 'theme']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('theme_colors');
    }
};
