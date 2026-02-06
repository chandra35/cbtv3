<?php

namespace App\Services;

use App\Models\MobileAppSetting;
use App\Models\ExamParticipant;
use App\Models\CBTActivityLog;

class MobileAppService
{
    /**
     * Validate exam password
     */
    public function validateExamPassword(MobileAppSetting $settings, $enteredPassword): bool
    {
        if (!$settings->enable_password_protection) {
            return true; // No password protection
        }

        return $settings->exam_password === $enteredPassword;
    }

    /**
     * Set exam password dari Laravel admin
     */
    public function setExamPassword(MobileAppSetting $settings, $password = null): string
    {
        if ($password) {
            $settings->exam_password = $password;
            $settings->enable_password_protection = true;
        } else {
            $settings->exam_password = $settings->generateExamPassword();
            $settings->enable_password_protection = true;
        }

        $settings->save();

        return $settings->exam_password;
    }

    /**
     * Reset exam password
     */
    public function resetExamPassword(MobileAppSetting $settings): void
    {
        $settings->exam_password = null;
        $settings->enable_password_protection = false;
        $settings->save();
    }

    /**
     * Get anti-cheating configuration untuk mobile app
     */
    public function getAntiCheatConfig(MobileAppSetting $settings): array
    {
        return [
            'prevent_screenshot' => $settings->prevent_screenshot,
            'prevent_screen_recording' => $settings->prevent_screen_recording,
            'prevent_app_switching' => $settings->prevent_app_switching,
            'enable_camera_monitoring' => $settings->enable_camera_monitoring,
            'require_face_detection' => $settings->require_face_detection,
            'disable_copy_paste' => $settings->disable_copy_paste,
            'disable_dev_tools' => $settings->disable_dev_tools,
            'max_idle_time' => $settings->max_idle_time,
            'lock_device_orientation' => $settings->lock_device_orientation,
            'locked_orientation' => $settings->locked_orientation,
        ];
    }

    /**
     * Track suspicious activity - app switching
     */
    public function trackAppSwitch(ExamParticipant $participant): void
    {
        CBTActivityLog::logAction($participant->id, 'app_switched', [
            'timestamp' => now(),
        ]);

        // Increment cheating flag
        if ($participant->exam->mobileSettings->prevent_app_switching) {
            $participant->update([
                'is_cheating_flagged' => true,
                'cheating_notes' => ($participant->cheating_notes ?? '') . '[' . now() . '] App switch detected. ',
            ]);
        }
    }

    /**
     * Track screenshot attempt
     */
    public function trackScreenshot(ExamParticipant $participant): void
    {
        CBTActivityLog::logAction($participant->id, 'screenshot_attempt', [
            'timestamp' => now(),
        ]);

        if ($participant->exam->mobileSettings->prevent_screenshot) {
            $participant->update([
                'is_cheating_flagged' => true,
                'cheating_notes' => ($participant->cheating_notes ?? '') . '[' . now() . '] Screenshot attempt. ',
            ]);
        }
    }

    /**
     * Validate IP Address
     */
    public function isIPAllowed(MobileAppSetting $settings, $ip): bool
    {
        return $settings->isIPAllowed($ip);
    }

    /**
     * Validate Device
     */
    public function isDeviceAllowed(MobileAppSetting $settings, $deviceId): bool
    {
        return $settings->isDeviceAllowed($deviceId);
    }

    /**
     * Add IP ke whitelist
     */
    public function addIPWhitelist(MobileAppSetting $settings, $ip): MobileAppSetting
    {
        $settings->addAllowedIP($ip);
        $settings->save();
        return $settings;
    }

    /**
     * Remove IP dari whitelist
     */
    public function removeIPWhitelist(MobileAppSetting $settings, $ip): MobileAppSetting
    {
        $settings->removeAllowedIP($ip);
        $settings->save();
        return $settings;
    }

    /**
     * Add device ke whitelist
     */
    public function addDeviceWhitelist(MobileAppSetting $settings, $deviceId): MobileAppSetting
    {
        $settings->addAllowedDevice($deviceId);
        $settings->save();
        return $settings;
    }

    /**
     * Remove device dari whitelist
     */
    public function removeDeviceWhitelist(MobileAppSetting $settings, $deviceId): MobileAppSetting
    {
        $settings->removeAllowedDevice($deviceId);
        $settings->save();
        return $settings;
    }

    /**
     * Check idle time dan auto-lock jika perlu
     */
    public function checkIdleTimeout(ExamParticipant $participant, $lastActivityTime): bool
    {
        $settings = $participant->exam->mobileSettings;
        $maxIdleSeconds = $settings->max_idle_time ?? 300; // Default 5 minutes

        $idleSeconds = now()->diffInSeconds($lastActivityTime);

        if ($idleSeconds > $maxIdleSeconds) {
            $participant->update([
                'status' => 'submitted',
                'submitted_at' => now(),
                'finished_at' => now(),
                'is_cheating_flagged' => true,
                'cheating_notes' => '[' . now() . '] Auto-submitted due to idle timeout.',
            ]);

            CBTActivityLog::logAction($participant->id, 'suspicious_activity', [
                'reason' => 'idle_timeout',
                'idle_seconds' => $idleSeconds,
            ]);

            return false; // Session expired
        }

        return true;
    }

    /**
     * Get allowed IP list
     */
    public function getAllowedIPs(MobileAppSetting $settings): array
    {
        return $settings->allowed_ips ?? [];
    }

    /**
     * Get allowed devices
     */
    public function getAllowedDevices(MobileAppSetting $settings): array
    {
        return $settings->allowed_devices ?? [];
    }

    /**
     * Get all mobile app settings config
     */
    public function getAllSettings(MobileAppSetting $settings): array
    {
        return [
            'anti_cheat' => $this->getAntiCheatConfig($settings),
            'password_protected' => $settings->enable_password_protection,
            'allowed_ips' => $this->getAllowedIPs($settings),
            'allowed_devices' => $this->getAllowedDevices($settings),
            'max_idle_time' => $settings->max_idle_time,
        ];
    }
}
