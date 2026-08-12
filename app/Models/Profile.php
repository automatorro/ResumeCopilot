<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'display_name', 'headline', 'phone',
        'email_contact', 'location', 'website', 'linkedin',
        'github_url', 'language_preference',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
