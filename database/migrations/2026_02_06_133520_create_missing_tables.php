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
        // Question Performance
        if (!Schema::hasTable('question_performance')) {
            Schema::create('question_performance', function (Blueprint $table) {
                $table->id();
                $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->integer('attempt_count')->default(0);
                $table->integer('correct_count')->default(0);
                $table->float('success_rate')->nullable();
                $table->float('average_time_taken')->nullable();
                $table->timestamps();
            });
        }

        // Exam Question Pools
        if (!Schema::hasTable('exam_question_pools')) {
            Schema::create('exam_question_pools', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->string('name');
                $table->integer('pool_size')->nullable();
                $table->boolean('randomize')->default(false);
                $table->timestamps();
            });
        }

        // External User Mappings
        if (!Schema::hasTable('external_user_mappings')) {
            Schema::create('external_user_mappings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('source_system');
                $table->string('external_id');
                $table->string('external_username')->nullable();
                $table->json('metadata')->nullable();
                $table->timestamps();
                
                $table->unique(['source_system', 'external_id']);
            });
        }

        // Mobile App Settings
        if (!Schema::hasTable('mobile_app_settings')) {
            Schema::create('mobile_app_settings', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->boolean('allow_mobile')->default(true);
                $table->boolean('require_lockdown_mode')->default(false);
                $table->boolean('allow_offline_mode')->default(false);
                $table->string('session_timeout_minutes')->default('30');
                $table->integer('max_devices')->default(1);
                $table->json('allowed_ip_addresses')->nullable();
                $table->timestamps();
            });
        }

        // Import Jobs
        if (!Schema::hasTable('import_jobs')) {
            Schema::create('import_jobs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
                $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
                $table->string('file_path');
                $table->string('import_type');
                $table->enum('status', ['pending', 'processing', 'completed', 'failed'])->default('pending');
                $table->integer('total_rows')->default(0);
                $table->integer('successful_imports')->default(0);
                $table->integer('failed_imports')->default(0);
                $table->text('error_message')->nullable();
                $table->timestamps();
            });
        }

        // Import Logs
        if (!Schema::hasTable('import_logs')) {
            Schema::create('import_logs', function (Blueprint $table) {
                $table->id();
                $table->foreignId('import_job_id')->constrained('import_jobs')->onDelete('cascade');
                $table->integer('row_number');
                $table->string('status');
                $table->text('error_message')->nullable();
                $table->json('data')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_logs');
        Schema::dropIfExists('import_jobs');
        Schema::dropIfExists('mobile_app_settings');
        Schema::dropIfExists('external_user_mappings');
        Schema::dropIfExists('exam_question_pools');
        Schema::dropIfExists('question_performance');
        Schema::dropIfExists('exam_essay_grades');
        Schema::dropIfExists('exam_analytics');
        Schema::dropIfExists('cbtactivity_logs');
    }
};
