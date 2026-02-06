<?php

use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\MobileAppSettingController;
use App\Http\Controllers\Admin\QuestionImportController;
use App\Http\Controllers\Admin\QuestionGroupController;
use App\Http\Controllers\Admin\QuestionController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Exam management
        Route::resource('exams', ExamController::class);
        Route::post('exams/{exam}/publish', [ExamController::class, 'publish'])->name('exams.publish');
        Route::post('exams/{exam}/unpublish', [ExamController::class, 'unpublish'])->name('exams.unpublish');
        Route::get('exams/{exam}/results', [ExamController::class, 'results'])->name('exams.results');
        Route::get('exams/{exam}/mobile-settings', [ExamController::class, 'mobileSettings'])->name('exams.mobile-settings');

        // Question Groups
        Route::get('exams/{exam}/question-groups', [QuestionGroupController::class, 'index'])->name('question-groups.index');
        Route::get('exams/{exam}/question-groups/create', [QuestionGroupController::class, 'create'])->name('question-groups.create');
        Route::post('exams/{exam}/question-groups', [QuestionGroupController::class, 'store'])->name('question-groups.store');
        Route::get('question-groups/{questionGroup}/edit', [QuestionGroupController::class, 'edit'])->name('question-groups.edit');
        Route::put('question-groups/{questionGroup}', [QuestionGroupController::class, 'update'])->name('question-groups.update');
        Route::delete('question-groups/{questionGroup}', [QuestionGroupController::class, 'destroy'])->name('question-groups.destroy');

        // Questions
        Route::get('question-groups/{group}/questions', [QuestionController::class, 'index'])->name('questions.index');
        Route::get('question-groups/{group}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
        Route::post('question-groups/{group}/questions', [QuestionController::class, 'store'])->name('questions.store');
        Route::get('questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
        Route::put('questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
        Route::delete('questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');

        // Mobile app settings
        Route::get('exams/{exam}/mobile-settings', [MobileAppSettingController::class, 'edit'])->name('mobile-settings.edit');
        Route::put('exams/{exam}/mobile-settings', [MobileAppSettingController::class, 'update'])->name('mobile-settings.update');
        Route::post('exams/{exam}/mobile-settings/generate-password', [MobileAppSettingController::class, 'generatePassword'])->name('mobile-settings.generate-password');
        Route::post('exams/{exam}/mobile-settings/reset-password', [MobileAppSettingController::class, 'resetPassword'])->name('mobile-settings.reset-password');

        // IP Whitelist
        Route::post('exams/{exam}/mobile-settings/ip-whitelist', [MobileAppSettingController::class, 'addIPWhitelist'])->name('mobile-settings.add-ip');
        Route::delete('exams/{exam}/mobile-settings/ip-whitelist', [MobileAppSettingController::class, 'removeIPWhitelist'])->name('mobile-settings.remove-ip');

        // Device Whitelist
        Route::post('exams/{exam}/mobile-settings/device-whitelist', [MobileAppSettingController::class, 'addDeviceWhitelist'])->name('mobile-settings.add-device');
        Route::delete('exams/{exam}/mobile-settings/device-whitelist', [MobileAppSettingController::class, 'removeDeviceWhitelist'])->name('mobile-settings.remove-device');

        // Activity logs
        Route::get('exams/{exam}/activity-logs', [MobileAppSettingController::class, 'activityLogs'])->name('activity-logs.index');
        Route::get('exams/{exam}/suspicious-activities', [MobileAppSettingController::class, 'suspiciousActivities'])->name('suspicious-activities.index');

        // Question import
        Route::get('groups/{group}/import', [QuestionImportController::class, 'create'])->name('imports.create');
        Route::post('groups/{group}/import', [QuestionImportController::class, 'store'])->name('imports.store');
        Route::get('groups/{group}/imports', [QuestionImportController::class, 'history'])->name('imports.history');
        Route::get('imports/{importJob}', [QuestionImportController::class, 'show'])->name('imports.show');
        Route::delete('imports/{importJob}/questions', [QuestionImportController::class, 'deleteImportedQuestions'])->name('imports.delete-questions');
    });
});

