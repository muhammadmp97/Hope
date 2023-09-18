<?php

namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\User;
use App\Notifications\ChallengeLikedNotification;

class LikeChallengeAction
{
    public function execute(User $user, Challenge $challenge): void
    {
        $challenge
            ->likes()
            ->updateOrCreate([
                'user_id' => $user->id,
            ]);

        if ($user->isNot($challenge->user)) {
            $challenge
                ->user
                ->notify(new ChallengeLikedNotification($user, $challenge));
        }
    }
}
