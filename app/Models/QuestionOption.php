<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class QuestionOption extends Model
{
    use HasUuids;

    protected $fillable = ['question_id', 'content', 'is_correct', 'order_index', 'image_url'];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
