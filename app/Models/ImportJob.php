<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ImportJob extends Model
{
    protected $fillable = [
        'question_group_id',
        'user_id',
        'import_type',
        'status',
        'file_path',
        'total_questions',
        'imported_at',
    ];

    protected $casts = [
        'imported_at' => 'datetime',
    ];

    /**
     * Get the question group associated with this import job
     */
    public function questionGroup(): BelongsTo
    {
        return $this->belongsTo(QuestionGroup::class);
    }

    /**
     * Get the user who initiated the import
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all logs for this import
     */
    public function logs(): HasMany
    {
        return $this->hasMany(ImportLog::class);
    }

    /**
     * Check if import was successful
     */
    public function isSuccessful(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if import failed
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }

    /**
     * Get error message if failed
     */
    public function getErrorMessage(): ?string
    {
        return $this->logs()->where('error_message', '!=', null)->first()?->error_message;
    }
}
