<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ChallengeCommentedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private Comment $comment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user' => [
                'id' => $this->comment->user->id,
                'nick_name' => $this->comment->user->nick_name,
                'avatar_url' => $this->comment->user->avatar_url,
            ],
            'challenge' => [
                'id' => $this->comment->commentable->id,
            ],
            'comment' => [
                'id' => $this->comment->id,
                'text' => $this->comment->text,
            ],
        ];
    }
}
