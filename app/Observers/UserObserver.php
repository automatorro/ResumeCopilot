<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->profile()->create([
            'display_name' => $user->name,
        ]);

        $user->careerBrain()->create([]);
    }
}
