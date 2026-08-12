<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AiCache extends Model
{
    protected $fillable = ['content_hash', 'action', 'result', 'expires_at'];

    protected $casts = [
        'result' => 'array',
        'expires_at' => 'datetime',
    ];
}
