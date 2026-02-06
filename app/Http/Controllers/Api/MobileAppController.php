<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamParticipant;
use App\Services\MobileAppService;
use Illuminate\Http\Request;

class MobileAppController extends Controller
{
    protected $mobileAppService;

    public function __construct(MobileAppService $mobileAppService)
    {
        $this->mobileAppService = $mobileAppService;
    }

    /**
     * Get mobile app settings untuk exam
     */
    public function getMobileSettings(Request $request)
    {
        // Get dari query atau from auth context
        $examId = $request->query('exam_id');
        
        if (!$examId) {
            return response()->json([
                'success' => false,
                'message' => 'exam_id required',
            ], 400);
        }

        $exam = Exam::findOrFail($examId);
        $settings = $exam->mobileSettings;

        if (!$settings) {
            // Create default settings
            $settings = $exam->mobileSettings()->create([
                'prevent_screenshot' => true,
                'prevent_app_switching' => true,
                'prevent_screen_recording' => true,
                'disable_copy_paste' => true,
                'max_idle_time' => 300, // 5 minutes
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $this->mobileAppService->getAllSettings($settings),
        ]);
    }

    /**
     * Validate device sebelum exam
     */
    public function validateDevice(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'device_id' => 'required|string',
            'device_ip' => 'required|ip',
        ]);

        $exam = Exam::findOrFail($validated['exam_id']);
        $settings = $exam->mobileSettings;

        if (!$settings) {
            $settings = $exam->mobileSettings()->create([
                'prevent_screenshot' => true,
                'prevent_app_switching' => true,
            ]);
        }

        // Check IP whitelist
        if (!$this->mobileAppService->isIPAllowed($settings, $validated['device_ip'])) {
            return response()->json([
                'success' => false,
                'message' => 'IP address tidak diizinkan untuk ujian ini',
            ], 403);
        }

        // Check device whitelist
        if (!$this->mobileAppService->isDeviceAllowed($settings, $validated['device_id'])) {
            return response()->json([
                'success' => false,
                'message' => 'Device ini tidak diizinkan untuk ujian',
            ], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Device validated',
        ]);
    }

    /**
     * Track general activity dari mobile app
     */
    public function trackActivity(Request $request)
    {
        $validated = $request->validate([
            'exam_participant_id' => 'required|exists:exam_participants,id',
            'action' => 'required|string',
            'metadata' => 'nullable|array',
        ]);

        $participant = ExamParticipant::findOrFail($validated['exam_participant_id']);

        \App\Models\CBTActivityLog::logAction(
            $participant->id,
            $validated['action'],
            $validated['metadata'] ?? []
        );

        return response()->json([
            'success' => true,
            'message' => 'Activity tracked',
        ]);
    }

    /**
     * Track app switch
     */
    public function trackAppSwitch(Request $request)
    {
        $validated = $request->validate([
            'exam_participant_id' => 'required|exists:exam_participants,id',
        ]);

        $participant = ExamParticipant::findOrFail($validated['exam_participant_id']);
        $this->mobileAppService->trackAppSwitch($participant);

        return response()->json([
            'success' => true,
            'message' => 'App switch tracked',
            'cheating_flagged' => $participant->is_cheating_flagged,
        ]);
    }

    /**
     * Track screenshot attempt
     */
    public function trackScreenshot(Request $request)
    {
        $validated = $request->validate([
            'exam_participant_id' => 'required|exists:exam_participants,id',
        ]);

        $participant = ExamParticipant::findOrFail($validated['exam_participant_id']);
        $this->mobileAppService->trackScreenshot($participant);

        return response()->json([
            'success' => true,
            'message' => 'Screenshot tracked',
            'cheating_flagged' => $participant->is_cheating_flagged,
        ]);
    }

    /**
     * Heartbeat - check if session still valid
     */
    public function sendHeartbeat(Request $request)
    {
        $validated = $request->validate([
            'exam_participant_id' => 'required|exists:exam_participants,id',
        ]);

        $participant = ExamParticipant::findOrFail($validated['exam_participant_id']);
        
        if (!$participant->isInProgress()) {
            return response()->json([
                'success' => false,
                'message' => 'Exam sudah selesai',
                'status' => $participant->status,
            ], 403);
        }

        // Check idle timeout
        $lastActivity = \App\Models\CBTActivityLog::where('exam_participant_id', $participant->id)
            ->latest('created_at')
            ->first();

        $lastActivityTime = $lastActivity ? $lastActivity->created_at : $participant->started_at;
        $stillValid = $this->mobileAppService->checkIdleTimeout($participant, $lastActivityTime);

        if (!$stillValid) {
            return response()->json([
                'success' => false,
                'message' => 'Session expired due to inactivity',
                'auto_submitted' => true,
            ], 403);
        }

        $remainingSeconds = $participant->getRemainingTime();

        return response()->json([
            'success' => true,
            'data' => [
                'remaining_seconds' => $remainingSeconds,
                'remaining_minutes' => floor($remainingSeconds / 60),
                'session_valid' => true,
            ],
        ]);
    }

    /**
     * Get anti-cheat config untuk mobile app
     */
    public function getAntiCheatConfig(Exam $exam)
    {
        $settings = $exam->mobileSettings ?? $exam->mobileSettings()->create([
            'prevent_screenshot' => true,
            'prevent_app_switching' => true,
        ]);

        return response()->json([
            'success' => true,
            'data' => $this->mobileAppService->getAntiCheatConfig($settings),
        ]);
    }
