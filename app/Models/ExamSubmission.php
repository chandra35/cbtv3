<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubmission extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'exam_participant_id',
        'question_id',
        'user_answer',
        'is_correct',
        'points_earned',
        'marked_for_review',
        'submitted_at',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'marked_for_review' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    // Relationships
    public function examParticipant()
    {
        return $this->belongsTo(ExamParticipant::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function essayGrade()
    {
        return $this->hasOne(ExamEssayGrade::class, 'submission_id');
    }

    // Methods
    public function isCorrect()
    {
        return $this->is_correct === true;
    }

    public function getPointsEarned()
    {
        if ($this->points_earned !== null) {
            return $this->points_earned;
        }
        return 0;
    }

    public function requiresGrading()
    {
        return $this->is_correct === null && $this->question->requiresManualGrading();
    }
}
