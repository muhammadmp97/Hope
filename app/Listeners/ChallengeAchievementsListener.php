<?php

namespace App\Listeners;

use App\Actions\Achievement\CreateUserAchievement;
use App\Services\Achievement;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChallengeAchievementsListener implements ShouldQueue
{
    public function __construct(
        public CreateUserAchievement $createUserAchievement
    ) {}

    public function handle($event)
    {
        $passedDays = $event
            ->challenge
            ->continued_at
            ->diff($event->challenge->created_at)
            ->d;

        $achievement = Achievement::getByPassedDays($passedDays);

        if (! $achievement) {
            return;
        }

        $this
            ->createUserAchievement
            ->execute($event->challenge->user, $achievement);
    }
}
