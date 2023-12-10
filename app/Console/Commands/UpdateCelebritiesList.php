<?php

namespace App\Console\Commands;

use App\Actions\Achievement\CreateUserAchievement;
use App\Models\User;
use App\Models\UserAchievement;
use App\Services\Achievement;
use Illuminate\Console\Command;

class UpdateCelebritiesList extends Command
{
    protected $signature = 'app:update-celebrities-list';

    protected $description = 'Update celebrities list and achievements';

    public function handle(CreateUserAchievement $createUserAchievement)
    {
        $topTenFollowersCount = User::query()
            ->withCount(['followers'])
            ->distinct('followers_count')
            ->where('followers_count', '>', 0)
            ->orderBy('followers_count', 'desc')
            ->limit(config('hope.celebrities_limit'))
            ->pluck('followers_count');

        $mostFollowedUsers = User::query()
            ->withCount(['followers'])
            ->orderBy('followers_count', 'desc')
            ->whereIn('followers_count', $topTenFollowersCount)
            ->get();

        $achievement = Achievement::getByName('celebrity');

        UserAchievement::query()
            ->where('achievement_id', $achievement['id'])
            ->delete();

        foreach ($mostFollowedUsers as $user) {
            $createUserAchievement->execute($user, $achievement);
        }

        return $this->comment('Done!');
    }
}
