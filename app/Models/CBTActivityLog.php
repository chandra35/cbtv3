<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CBTActivityLog extends Model
{
    use HasFactory;

    protected $table = 'cbtactivity_logs';

    const UPDATED_AT = null;

    protected $fillable = [
        'exam_participant_id',
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'device_id',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    // Relationships
    public function examParticipant()
    {
        return $this->belongsTo(ExamParticipant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Methods
    public static function logAction($examParticipantId, $action, $data = [])
    {
        return self::create([
            'exam_participant_id' => $examParticipantId,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_id' => $data['device_id'] ?? null,
            'metadata' => $data,
        ]);
    }

    public function isSuspiciousActivity()
    {
        return in_array($this->action, ['app_switched', 'screenshot_attempt', 'suspicious_activity']);
    }
}
