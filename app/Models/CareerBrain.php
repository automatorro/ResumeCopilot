<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CareerBrain extends Model
{
    protected $fillable = [
        'user_id', 'summary', 'goals', 'target_role',
        'target_industry', 'availability',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
