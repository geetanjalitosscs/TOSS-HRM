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
        Schema::create('buzz_post_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post_id');
            $table->enum('type', ['photo', 'video']);
            $table->string('path', 500);
            $table->string('original_name', 255);
            $table->string('mime_type', 100)->nullable();
            $table->unsignedBigInteger('size_bytes')->nullable();
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('buzz_posts')->onDelete('cascade');
            $table->index('post_id');
            $table->index('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buzz_post_attachments');
    }
};
