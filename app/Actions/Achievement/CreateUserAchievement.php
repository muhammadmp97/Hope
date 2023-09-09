<?php

namespace App\Actions\Achievement;

use App\Models\User;

class CreateUserAchievement
{
    public function execute(User $user, array $achievement)
    {
        $user
            ->achievements()
            ->create([
                'achievement_id' => $achievement['id'],
            ]);
        
        $user->score += $achievement['score'];
        $user->save();
    }
}
