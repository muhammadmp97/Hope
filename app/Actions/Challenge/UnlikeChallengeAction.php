<?php

namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\User;

class UnlikeChallengeAction
{
    public function execute(User $user, Challenge $challenge): void
    {
        $challenge
            ->likes()
            ->where([
                'user_id' => $user->id,
            ])
            ->delete();
    }
}
