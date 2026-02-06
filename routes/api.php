<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamController;
use App\Http\Controllers\Api\MobileAppController;

Route::prefix('v1')->group(function () {
    
    // Public routes (sebelum login)
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/login-mobile', [AuthController::class, 'loginMobile']);
    Route::post('/auth/validate-exam-password', [AuthController::class, 'validateExamPassword']);
    
    // Protected routes (setelah login)
    Route::middleware('auth:sanctum')->group(function () {
        
        // Auth endpoints
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        Route::get('/auth/me', [AuthController::class, 'getCurrentUser']);
        
        // Exam endpoints
        Route::prefix('exams')->group(function () {
            Route::get('/', [ExamController::class, 'listAvailableExams']);
            Route::get('/{exam}', [ExamController::class, 'getExamDetail']);
            Route::post('/{exam}/start', [ExamController::class, 'startExam']);
            Route::get('/{exam}/status', [ExamController::class, 'getExamStatus']);
            Route::get('/{exam}/questions', [ExamController::class, 'getQuestions']);
            Route::get('/{exam}/questions/{question}', [ExamController::class, 'getQuestion']);
            Route::post('/{exam}/answer', [ExamController::class, 'submitAnswer']);
            Route::post('/{exam}/mark-review', [ExamController::class, 'markForReview']);
            Route::post('/{exam}/submit', [ExamController::class, 'submitExam']);
            Route::get('/{exam}/results', [ExamController::class, 'getResults']);
        });
        
        // Mobile app specific endpoints
        Route::prefix('mobile')->group(function () {
            Route::get('/settings', [MobileAppController::class, 'getMobileSettings']);
            Route::post('/validate-device', [MobileAppController::class, 'validateDevice']);
            Route::post('/track-activity', [MobileAppController::class, 'trackActivity']);
            Route::post('/track-app-switch', [MobileAppController::class, 'trackAppSwitch']);
            Route::post('/track-screenshot', [MobileAppController::class, 'trackScreenshot']);
            Route::post('/heartbeat', [MobileAppController::class, 'sendHeartbeat']);
            Route::get('/anti-cheat-config/{exam}', [MobileAppController::class, 'getAntiCheatConfig']);
        });
    });
});
