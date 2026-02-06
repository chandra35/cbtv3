<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionGroup extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $fillable = [
        'exam_id',
        'name',
        'description',
        'order_index',
        'randomize_questions',
        'randomize_options',
        'show_questions_per_page',
        'created_by',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'randomize_options' => 'boolean',
    ];

    // Relationships
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class)->orderBy('created_at');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function questionPool()
    {
        return $this->hasOne(ExamQuestionPool::class);
    }

    public function importJobs()
    {
        return $this->hasMany(ImportJob::class);
    }

    // Methods
    public function getTotalQuestions()
    {
        return $this->questions()->count();
    }

    public function getTotalPoints()
    {
        return $this->questions()->sum('points');
    }
}
