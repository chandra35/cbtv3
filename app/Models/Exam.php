<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Exam extends Model
{
    use HasFactory, SoftDeletes, HasRoles, HasUuids;

    protected $fillable = [
        'exam_name',
        'exam_type',
        'description',
        'jenjang',
        'subject_ids',
        'duration',
        'passing_grade',
        'max_attempts',
        'show_answers_after',
        'allow_review_before_submit',
        'randomize_group_order',
        'randomize_questions_per_user',
        'passing_message',
        'failing_message',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'is_published',
        'created_by',
    ];

    protected $casts = [
        'subject_ids' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'show_answers_after' => 'boolean',
        'allow_review_before_submit' => 'boolean',
        'randomize_group_order' => 'boolean',
        'randomize_questions_per_user' => 'boolean',
    ];

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questionGroups()
    {
        return $this->hasMany(QuestionGroup::class)->orderBy('order_index');
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_questions')
            ->withPivot('order_index', 'points_override')
            ->orderBy('exam_questions.order_index');
    }

    public function participants()
    {
        return $this->hasMany(ExamParticipant::class);
    }

    public function mobileSettings()
    {
        return $this->hasOne(MobileAppSetting::class);
    }

    public function questionPools()
    {
        return $this->hasMany(ExamQuestionPool::class);
    }

    public function analytics()
    {
        return $this->hasOne(ExamAnalytic::class);
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeActive($query)
    {
        return $query->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>', now());
    }

    public function scopeEnded($query)
    {
        return $query->where('end_date', '<', now());
    }

    // Methods
    public function isActive()
    {
        return $this->is_published && now()->between($this->start_date, $this->end_date);
    }

    public function canStartExam()
    {
        return $this->is_published && now() >= $this->start_date && now() <= $this->end_date;
    }

    public function getTotalQuestions()
    {
        return $this->questions()->count();
    }

    public function getTotalPoints()
    {
        return $this->examQuestions()
            ->selectRaw('SUM(COALESCE(points_override, questions.points)) as total')
            ->join('questions', 'exam_questions.question_id', '=', 'questions.id')
            ->value('total') ?? 0;
    }
}
