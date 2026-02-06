<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'question_group_id',
        'question_type',
        'content',
        'difficulty_level',
        'points',
        'instructions',
        'image_url',
        'file_url',
        'explanation',
        'is_randomized',
        'import_source',
        'metadata',
        'created_by',
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_randomized' => 'boolean',
    ];

    // Relationships
    public function questionGroup()
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    public function options()
    {
        return $this->hasMany(QuestionOption::class)->orderBy('order_index');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function submissions()
    {
        return $this->hasMany(ExamSubmission::class);
    }

    public function performance()
    {
        return $this->hasOne(QuestionPerformance::class);
    }

    // Methods
    public function getCorrectOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }

    public function isMultipleChoice()
    {
        return $this->question_type === 'multiple_choice';
    }

    public function isEssay()
    {
        return $this->question_type === 'essay';
    }

    public function requiresManualGrading()
    {
        return in_array($this->question_type, ['essay', 'short_answer']);
    }
}
