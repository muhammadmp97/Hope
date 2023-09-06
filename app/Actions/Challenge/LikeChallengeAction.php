<?php

namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\User;

class LikeChallengeAction
{
    public function execute(User $user, Challenge $challenge): void
    {
        $challenge
            ->likes()
            ->updateOrCreate([
                'user_id' => $user->id,
            ]);
    }
}
