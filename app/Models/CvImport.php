<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CvImport extends Model
{
    protected $fillable = [
        'user_id', 'file_name', 'file_path', 'mime_type',
        'content_hash', 'status', 'parsed_data', 'error_message',
    ];

    protected $casts = [
        'parsed_data' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
