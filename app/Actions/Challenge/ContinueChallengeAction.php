<?php

namespace App\Actions\Challenge;

use App\Enums\ChallengeStatus;
use App\Models\Challenge;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ContinueChallengeAction
{
    public function execute(Challenge $challenge): Challenge
    {
        if ($challenge->status !== ChallengeStatus::ONGOING->value) {
            throw new HttpException(400, 'This challenge is not ongoing!');
        }

        if ($challenge->continued_at->diffInDays() === 0) {
            throw new HttpException(400, 'Not a day has passed yet!');
        }

        $challenge->timestamps = false;
        $challenge->continued_at = now();
        $challenge->save();

        return $challenge;
    }
}
