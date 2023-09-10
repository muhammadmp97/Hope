<?php

namespace App\Actions\Achievement;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUserAchievement
{
    public function execute(User $user, array $achievement)
    {
        DB::transaction(function () use ($user, $achievement) {
            $user
            ->achievements()
            ->create([
                'achievement_id' => $achievement['id'],
            ]);
        
            $user->score += $achievement['score'];
            $user->save();
        });
    }
}
