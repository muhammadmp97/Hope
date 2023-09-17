<?php

namespace App\Listeners;

use App\Actions\Achievement\CreateUserAchievement;
use App\Services\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChallengeAchievementsListener implements ShouldQueue
{
    public function __construct(
        public CreateUserAchievement $createUserAchievement
    ) {
    }

    public function handle($event)
    {
        $achievement = Achievement::getByPassedDays($event->challenge->passedDays());

        if (! $achievement) {
            return;
        }

        $this
            ->createUserAchievement
            ->execute($event->challenge->user, $achievement);
    }
}
