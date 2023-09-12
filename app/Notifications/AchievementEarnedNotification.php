<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class AchievementEarnedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private array $achievement
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->achievement['name'],
        ];
    }
}
