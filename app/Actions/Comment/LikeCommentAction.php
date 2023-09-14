<?php

namespace App\Actions\Comment;

use App\Models\Comment;
use App\Models\User;
use App\Notifications\CommentLikedNotification;

class LikeCommentAction
{
    public function execute(User $user, Comment $comment): void
    {
        $comment
            ->likes()
            ->updateOrCreate([
                'user_id' => $user->id,
            ]);

        $comment
            ->user
            ->notify(new CommentLikedNotification($user, $comment));
    }
}
