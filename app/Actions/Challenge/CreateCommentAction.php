<?php

namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\Comment;
use App\Models\User;

class CreateCommentAction
{
    public function execute(User $user, Challenge $challenge, array $data): Comment
    {
        return $challenge
            ->comments()
            ->create([
                'user_id' => $user->id,
                'text' => $data['text'],
            ]);
    }
}
