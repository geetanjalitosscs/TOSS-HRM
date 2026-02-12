<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This migration creates the supporting tables for
     * My Info → Qualifications:
     * - employee_work_experience
     * - employee_education
     * - employee_skills
     * - employee_languages
     * - employee_licenses
     * - employee_qualification_attachments
     */
    public function up(): void
    {
        // Work Experience
        if (! Schema::hasTable('employee_work_experience')) {
            Schema::create('employee_work_experience', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->string('company', 191);
                $table->string('job_title', 191);
                $table->date('from_date')->nullable();
                $table->date('to_date')->nullable();
                $table->text('comment')->nullable();
                $table->timestamps();

                $table->index('employee_id', 'idx_work_exp_employee');
                $table->foreign('employee_id', 'fk_work_exp_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
            });
        }

        // Education
        if (! Schema::hasTable('employee_education')) {
            Schema::create('employee_education', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->string('level', 100);
                $table->string('institute', 191)->nullable();
                $table->string('major_specialization', 191)->nullable();
                $table->string('year', 20)->nullable();
                $table->string('gpa_score', 50)->nullable();
                $table->date('start_date')->nullable();
                $table->date('end_date')->nullable();
                $table->timestamps();

                $table->index('employee_id', 'idx_education_employee');
                $table->foreign('employee_id', 'fk_education_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
            });
        }

        // Skills
        if (! Schema::hasTable('employee_skills')) {
            Schema::create('employee_skills', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->string('skill', 191);
                $table->string('years_of_experience', 50)->nullable();
                $table->text('comments')->nullable();
                $table->timestamps();

                $table->index('employee_id', 'idx_skills_employee');
                $table->foreign('employee_id', 'fk_skills_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
            });
        }

        // Languages
        if (! Schema::hasTable('employee_languages')) {
            Schema::create('employee_languages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->string('language', 100);
                $table->string('fluency', 100);
                $table->string('competency', 100);
                $table->text('comments')->nullable();
                $table->timestamps();

                $table->index('employee_id', 'idx_languages_employee');
                $table->foreign('employee_id', 'fk_languages_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
            });
        }

        // Licenses
        if (! Schema::hasTable('employee_licenses')) {
            Schema::create('employee_licenses', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->string('license_type', 191);
                $table->string('license_number', 100)->nullable();
                $table->date('issued_date')->nullable();
                $table->date('expiry_date')->nullable();
                $table->timestamps();

                $table->index('employee_id', 'idx_licenses_employee');
                $table->foreign('employee_id', 'fk_licenses_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');
            });
        }

        // Qualification attachments
        if (! Schema::hasTable('employee_qualification_attachments')) {
            Schema::create('employee_qualification_attachments', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('employee_id');
                $table->unsignedBigInteger('file_upload_id');
                $table->text('comment')->nullable();
                $table->timestamp('created_at')->useCurrent();

                $table->index('employee_id', 'idx_qual_att_employee');
                $table->index('file_upload_id', 'idx_qual_att_file');

                $table->foreign('employee_id', 'fk_qual_att_employee')
                    ->references('id')
                    ->on('employees')
                    ->onDelete('cascade');

                $table->foreign('file_upload_id', 'fk_qual_att_file')
                    ->references('id')
                    ->on('file_uploads')
                    ->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_qualification_attachments');
        Schema::dropIfExists('employee_licenses');
        Schema::dropIfExists('employee_languages');
        Schema::dropIfExists('employee_skills');
        Schema::dropIfExists('employee_education');
        Schema::dropIfExists('employee_work_experience');
    }
};


