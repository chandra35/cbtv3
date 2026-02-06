<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Exams Table
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->string('exam_name');
            $table->enum('exam_type', ['entrance', 'pre_test', 'diagnostic', 'placement'])->default('entrance');
            $table->text('description')->nullable();
            $table->enum('jenjang', ['SMP', 'SMA', 'SMK'])->nullable();
            $table->json('subject_ids')->nullable();
            $table->integer('duration');
            $table->integer('passing_grade')->default(0);
            $table->integer('max_attempts')->default(1);
            $table->boolean('show_answers_after')->default(false);
            $table->boolean('allow_review_before_submit')->default(false);
            $table->boolean('randomize_group_order')->default(false);
            $table->boolean('randomize_questions_per_user')->default(false);
            $table->text('passing_message')->nullable();
            $table->text('failing_message')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Question Groups Table
        Schema::create('question_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->nullable()->constrained('exams')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('order_index')->default(0);
            $table->boolean('randomize_questions')->default(false);
            $table->boolean('randomize_options')->default(false);
            $table->integer('show_questions_per_page')->default(1);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Questions Table
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_group_id')->nullable()->constrained('question_groups')->onDelete('cascade');
            $table->enum('question_type', ['multiple_choice', 'true_false', 'short_answer', 'essay', 'matching', 'fill_in_blank'])->default('multiple_choice');
            $table->longText('content');
            $table->enum('difficulty_level', ['easy', 'medium', 'hard'])->default('medium');
            $table->integer('points')->default(1);
            $table->text('instructions')->nullable();
            $table->string('image_url')->nullable();
            $table->string('file_url')->nullable();
            $table->longText('explanation')->nullable();
            $table->boolean('is_randomized')->default(false);
            $table->enum('import_source', ['manual', 'word', 'txt', 'blackboard'])->default('manual');
            $table->json('metadata')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Question Options
        Schema::create('question_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->longText('content');
            $table->boolean('is_correct')->default(false);
            $table->integer('order_index')->default(0);
            $table->string('image_url')->nullable();
            $table->timestamps();
        });

        // Exam Questions
        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->foreignId('question_group_id')->nullable()->constrained('question_groups')->onDelete('cascade');
            $table->integer('order_index')->default(0);
            $table->integer('points_override')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_id', 'question_id']);
        });

        // Exam Participants
        Schema::create('exam_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('source_system', ['cbt_internal', 'simansa', 'ppdb'])->default('cbt_internal');
            $table->string('external_id')->nullable();
            $table->string('class_id')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('submitted_at')->nullable();
            $table->dateTime('finished_at')->nullable();
            $table->integer('score')->nullable();
            $table->float('percentage')->nullable();
            $table->enum('status', ['not_started', 'in_progress', 'submitted', 'graded', 'completed'])->default('not_started');
            $table->integer('attempt_number')->default(1);
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->boolean('is_cheating_flagged')->default(false);
            $table->text('cheating_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['exam_id', 'user_id', 'attempt_number']);
            $table->index(['exam_id', 'status']);
        });

        // User Exam Questions
        Schema::create('user_exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_participant_id')->constrained('exam_participants')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->integer('order_in_exam');
            $table->json('randomized_options')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_participant_id', 'question_id']);
        });

        // Exam Submissions
        Schema::create('exam_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_participant_id')->constrained('exam_participants')->onDelete('cascade');
            $table->foreignId('question_id')->constrained('questions')->onDelete('cascade');
            $table->longText('user_answer')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->integer('points_earned')->nullable();
            $table->boolean('marked_for_review')->default(false);
            $table->dateTime('submitted_at')->nullable();
            $table->timestamps();
            
            $table->unique(['exam_participant_id', 'question_id']);
            $table->index(['exam_participant_id', 'submitted_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_submissions');
        Schema::dropIfExists('user_exam_questions');
        Schema::dropIfExists('exam_participants');
        Schema::dropIfExists('exam_questions');
        Schema::dropIfExists('question_options');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_groups');
        Schema::dropIfExists('exams');    }
};