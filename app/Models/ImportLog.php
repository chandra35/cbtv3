<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ImportLog extends Model
{
    protected $fillable = [
        'import_job_id',
        'error_message',
        'line_number',
        'details',
    ];

    protected $casts = [
        'details' => 'json',
    ];

    /**
     * Get the import job associated with this log
     */
    public function importJob(): BelongsTo
    {
        return $this->belongsTo(ImportJob::class);
    }

    /**
     * Check if this is an error log
     */
    public function isError(): bool
    {
        return $this->error_message !== null;
    }
}
