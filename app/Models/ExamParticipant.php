<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExamParticipant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'exam_id',
        'user_id',
        'source_system',
        'external_id',
        'class_id',
        'started_at',
        'submitted_at',
        'finished_at',
        'score',
        'percentage',
        'status',
        'attempt_number',
        'ip_address',
        'user_agent',
        'is_cheating_flagged',
        'cheating_notes',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'submitted_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_cheating_flagged' => 'boolean',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }

    public function userExamQuestions()
    {
        return $this->hasMany(UserExamQuestion::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(CBTActivityLog::class);
    }

    // Methods
    public function isInProgress()
    {
        return $this->status === 'in_progress';
    }

    public function isCompleted()
    {
        return in_array($this->status, ['submitted', 'graded', 'completed']);
    }

    public function isPassed()
    {
        return $this->score >= $this->exam->passing_grade;
    }

    public function getRemainingTime()
    {
        if (!$this->started_at) return null;
        
        $endTime = $this->started_at->addMinutes($this->exam->duration);
        $remaining = $endTime->diffInSeconds(now());
        
        return max(0, $remaining);
    }

    public function getProgressPercentage()
    {
        $totalQuestions = $this->userExamQuestions()->count();
        if ($totalQuestions === 0) return 0;
        
        $answered = $this->submissions()->whereNotNull('user_answer')->count();
        return round(($answered / $totalQuestions) * 100, 2);
    }

    public function canSubmitExam()
    {
        return $this->status === 'in_progress' && $this->getRemainingTime() > 0;
    }
}
