<?php

namespace App\Actions\Challenge;

use App\Enums\ChallengeStatus;
use App\Events\ChallengeCreated;
use App\Exceptions\UserHaveUnCompletedChallengeException;
use App\Models\Challenge;
use App\Models\User;

class CreateChallengeAction
{
    public function execute(User $user, array $data): Challenge
    {
        $ongoingChallenge = Challenge::query()
            ->where('user_id', $user->id)
            ->where('status', ChallengeStatus::ONGOING->value);

        if ($ongoingChallenge->exists()) {
            throw new UserHaveUnCompletedChallengeException();
        }

        $data = array_merge($data, [
            'user_id' => $user->id,
            'status' => ChallengeStatus::ONGOING->value,
            'continued_at' => now(),
        ]);

        $challenge = Challenge::create($data);

        ChallengeCreated::dispatch($challenge);

        return $challenge;
    }
}
