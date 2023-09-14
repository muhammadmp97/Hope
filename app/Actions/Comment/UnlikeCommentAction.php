<?php

namespace App\Actions\Comment;

use App\Models\Comment;
use App\Models\User;

class UnlikeCommentAction
{
    public function execute(User $user, Comment $comment): void
    {
        $comment
            ->likes()
            ->where([
                'user_id' => $user->id,
            ])
            ->delete();
    }
}
