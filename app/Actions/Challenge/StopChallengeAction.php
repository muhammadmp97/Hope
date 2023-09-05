<?php

namespace App\Actions\Challenge;

use App\Enums\ChallengeStatus;
use App\Models\Challenge;
use Symfony\Component\HttpKernel\Exception\HttpException;

class StopChallengeAction
{
    public function execute(Challenge $challenge): void
    {
        if ($challenge->status !== ChallengeStatus::ONGOING->value) {
            throw new HttpException(400, 'This challenge is not ongoing!');
        }

        $challenge->update([
            'status' => ChallengeStatus::STOPPED,
        ]);
    }
}
