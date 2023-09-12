<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewFollowerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $follower
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
                'id' => $this->follower->id,
                'nick_name' => $this->follower->nick_name,
                'avatar_url' => $this->follower->avatar_url,
            ],
        ];
    }
}
