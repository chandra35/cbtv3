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
        // Add UUID columns to all tables
        $tables = [
            'users',
            'exams',
            'question_groups',
            'questions',
            'question_options',
            'exam_questions',
            'exam_participants',
            'exam_submissions',
            'user_exam_questions',
            'cbtactivity_logs',
            'exam_analytics',
            'exam_essay_grades',
            'question_performance',
            'exam_question_pools',
            'external_user_mappings',
            'mobile_app_settings',
            'import_jobs',
            'import_logs',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'uuid')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->uuid('uuid')->nullable()->after('id')->unique();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'users',
            'exams',
            'question_groups',
            'questions',
            'question_options',
            'exam_questions',
            'exam_participants',
            'exam_submissions',
            'user_exam_questions',
            'cbtactivity_logs',
            'exam_analytics',
            'exam_essay_grades',
            'question_performance',
            'exam_question_pools',
            'external_user_mappings',
            'mobile_app_settings',
            'import_jobs',
            'import_logs',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'uuid')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('uuid');
                });
            }
        }
    }
};
