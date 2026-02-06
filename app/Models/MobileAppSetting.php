<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileAppSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'exam_password',
        'enable_password_protection',
        'prevent_screenshot',
        'prevent_screen_recording',
        'prevent_app_switching',
        'enable_camera_monitoring',
        'require_face_detection',
        'lock_device_orientation',
        'locked_orientation',
        'max_idle_time',
        'disable_copy_paste',
        'disable_dev_tools',
        'allowed_ips',
        'allowed_devices',
    ];

    protected $casts = [
        'enable_password_protection' => 'boolean',
        'prevent_screenshot' => 'boolean',
        'prevent_screen_recording' => 'boolean',
        'prevent_app_switching' => 'boolean',
        'enable_camera_monitoring' => 'boolean',
        'require_face_detection' => 'boolean',
        'lock_device_orientation' => 'boolean',
        'disable_copy_paste' => 'boolean',
        'disable_dev_tools' => 'boolean',
        'allowed_ips' => 'array',
        'allowed_devices' => 'array',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Methods untuk password management
    public function generateExamPassword()
    {
        $this->exam_password = str()->random(10);
        return $this->exam_password;
    }

    public function resetExamPassword()
    {
        $this->exam_password = null;
        $this->enable_password_protection = false;
        return true;
    }

    // Methods untuk IP whitelist
    public function addAllowedIP($ip)
    {
        $ips = $this->allowed_ips ?? [];
        if (!in_array($ip, $ips)) {
            $ips[] = $ip;
            $this->allowed_ips = $ips;
        }
        return $this;
    }

    public function removeAllowedIP($ip)
    {
        $ips = $this->allowed_ips ?? [];
        $this->allowed_ips = array_filter($ips, fn($item) => $item !== $ip);
        return $this;
    }

    // Methods untuk Device whitelist
    public function addAllowedDevice($deviceId)
    {
        $devices = $this->allowed_devices ?? [];
        if (!in_array($deviceId, $devices)) {
            $devices[] = $deviceId;
            $this->allowed_devices = $devices;
        }
        return $this;
    }

    public function removeAllowedDevice($deviceId)
    {
        $devices = $this->allowed_devices ?? [];
        $this->allowed_devices = array_filter($devices, fn($item) => $item !== $deviceId);
        return $this;
    }

    public function isIPAllowed($ip)
    {
        if (empty($this->allowed_ips)) return true;
        return in_array($ip, $this->allowed_ips);
    }

    public function isDeviceAllowed($deviceId)
    {
        if (empty($this->allowed_devices)) return true;
        return in_array($deviceId, $this->allowed_devices);
    }

    public function getAntiCheatSettings()
    {
        return [
            'prevent_screenshot' => $this->prevent_screenshot,
            'prevent_screen_recording' => $this->prevent_screen_recording,
            'prevent_app_switching' => $this->prevent_app_switching,
            'enable_camera_monitoring' => $this->enable_camera_monitoring,
            'require_face_detection' => $this->require_face_detection,
            'disable_copy_paste' => $this->disable_copy_paste,
            'disable_dev_tools' => $this->disable_dev_tools,
            'max_idle_time' => $this->max_idle_time,
        ];
    }
}
