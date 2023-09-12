<?php

namespace App\Actions\Challenge;

use App\Events\CommentCreated;
use App\Models\Challenge;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\ChallengeCommentedNotification;

class CreateCommentAction
{
    public function execute(User $user, Challenge $challenge, array $data): Comment
    {
        $comment = $challenge
            ->comments()
            ->create([
                'user_id' => $user->id,
                'text' => $data['text'],
            ]);

        $challenge
            ->user
            ->notify(new ChallengeCommentedNotification($comment));

        CommentCreated::dispatch($comment);

        return $comment;
    }
}
