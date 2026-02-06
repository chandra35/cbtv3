<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\MobileAppSetting;
use App\Services\MobileAppService;
use Illuminate\Http\Request;

class MobileAppSettingController extends Controller
{
    protected $mobileAppService;

    public function __construct(MobileAppService $mobileAppService)
    {
        $this->mobileAppService = $mobileAppService;
    }

    /**
     * Display mobile app settings form
     */
    public function edit(Exam $exam)
    {
        $settings = $exam->mobileSettings ?? new MobileAppSetting(['exam_id' => $exam->id]);
        $allowedIPs = $settings->getAllowedIPs();
        $allowedDevices = $settings->getAllowedDevices();

        return view('admin.exams.mobile-settings', compact('exam', 'settings', 'allowedIPs', 'allowedDevices'));
    }

    /**
     * Update mobile app settings
     */
    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'enable_password_protection' => 'boolean',
            'exam_password' => 'nullable|string|min:4|max:20',
            'max_idle_time' => 'required|integer|min:60|max:3600',
            'prevent_screenshot' => 'boolean',
            'prevent_screen_recording' => 'boolean',
            'prevent_app_switching' => 'boolean',
            'enable_camera_monitoring' => 'boolean',
            'require_face_detection' => 'boolean',
            'disable_copy_paste' => 'boolean',
            'disable_dev_tools' => 'boolean',
            'lock_device_orientation' => 'boolean',
        ]);

        $settings = $exam->mobileSettings ?? MobileAppSetting::create(['exam_id' => $exam->id]);

        // Handle password jika ada
        if ($request->filled('exam_password')) {
            $this->mobileAppService->setExamPassword($settings, $request->input('exam_password'));
            unset($validated['exam_password']);
        }

        $settings->update($validated);

        return redirect()->back()->with('success', 'Mobile app settings updated');
    }

    /**
     * Generate random password
     */
    public function generatePassword(Exam $exam)
    {
        $settings = $exam->mobileSettings ?? MobileAppSetting::create(['exam_id' => $exam->id]);

        $password = $this->mobileAppService->generateExamPassword($settings);

        return response()->json([
            'success' => true,
            'password' => $password,
        ]);
    }

    /**
     * Reset password
     */
    public function resetPassword(Exam $exam)
    {
        $settings = $exam->mobileSettings;

        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found',
            ], 404);
        }

        $this->mobileAppService->resetExamPassword($settings);

        return response()->json([
            'success' => true,
            'message' => 'Password reset',
        ]);
    }

    /**
     * Add IP to whitelist
     */
    public function addIPWhitelist(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'ip' => 'required|ip',
        ]);

        $settings = $exam->mobileSettings ?? MobileAppSetting::create(['exam_id' => $exam->id]);

        $this->mobileAppService->addIPWhitelist($settings, $validated['ip']);

        return response()->json([
            'success' => true,
            'message' => 'IP added to whitelist',
            'allowed_ips' => $settings->getAllowedIPs(),
        ]);
    }

    /**
     * Remove IP from whitelist
     */
    public function removeIPWhitelist(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'ip' => 'required|ip',
        ]);

        $settings = $exam->mobileSettings;

        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found',
            ], 404);
        }

        $this->mobileAppService->removeIPWhitelist($settings, $validated['ip']);

        return response()->json([
            'success' => true,
            'message' => 'IP removed from whitelist',
            'allowed_ips' => $settings->getAllowedIPs(),
        ]);
    }

    /**
     * Add device to whitelist
     */
    public function addDeviceWhitelist(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
            'device_name' => 'required|string|max:100',
        ]);

        $settings = $exam->mobileSettings ?? MobileAppSetting::create(['exam_id' => $exam->id]);

        $this->mobileAppService->addDeviceWhitelist($settings, $validated['device_id'], $validated['device_name']);

        return response()->json([
            'success' => true,
            'message' => 'Device added to whitelist',
            'allowed_devices' => $settings->getAllowedDevices(),
        ]);
    }

    /**
     * Remove device from whitelist
     */
    public function removeDeviceWhitelist(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'device_id' => 'required|string',
        ]);

        $settings = $exam->mobileSettings;

        if (!$settings) {
            return response()->json([
                'success' => false,
                'message' => 'Settings not found',
            ], 404);
        }

        $this->mobileAppService->removeDeviceWhitelist($settings, $validated['device_id']);

        return response()->json([
            'success' => true,
            'message' => 'Device removed from whitelist',
            'allowed_devices' => $settings->getAllowedDevices(),
        ]);
    }

    /**
     * View all activity logs untuk exam
     */
    public function activityLogs(Exam $exam)
    {
        $logs = $exam->participants()
            ->join('cbt_activity_logs', 'exam_participants.id', '=', 'cbt_activity_logs.exam_participant_id')
            ->select('cbt_activity_logs.*', 'exam_participants.user_id')
            ->with('user:id,name')
            ->latest('cbt_activity_logs.created_at')
            ->paginate(50);

        return view('admin.exams.activity-logs', compact('exam', 'logs'));
    }

    /**
     * Get suspicious activities
     */
    public function suspiciousActivities(Exam $exam)
    {
        $suspiciousLogs = $exam->participants()
            ->join('cbt_activity_logs', 'exam_participants.id', '=', 'cbt_activity_logs.exam_participant_id')
            ->where('cbt_activity_logs.action', 'suspicious_activity')
            ->select('cbt_activity_logs.*', 'exam_participants.user_id')
            ->with('user:id,name', 'examParticipant')
            ->latest('cbt_activity_logs.created_at')
            ->get()
            ->map(function ($log) {
                return [
                    'user_name' => $log->user->name,
                    'action' => $log->action,
                    'details' => json_decode($log->details, true),
                    'ip_address' => $log->ip_address,
                    'user_agent' => $log->user_agent,
                    'created_at' => $log->created_at,
                ];
            });

        return view('admin.exams.suspicious-activities', compact('exam', 'suspiciousLogs'));
    }
}
