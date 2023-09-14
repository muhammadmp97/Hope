<?php

namespace App\Notifications;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class CommentLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $user,
        private Comment $comment,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'nick_name' => $this->user->nick_name,
                'avatar_url' => $this->user->avatar_url,
            ],
            'comment' => [
                'id' => $this->comment->id,
                'text' => $this->comment->text,
            ],
        ];
    }
}
