<?php

namespace App\Notifications;

use App\Models\Challenge;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class ChallengeLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private User $user,
        private Challenge $challenge,
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
            'challenge' => [
                'id' => $this->challenge->id,
            ],
        ];
    }
}
