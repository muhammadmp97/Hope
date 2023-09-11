<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $type = [
            'App\Notifications\AchievementEarnedNotification' => 'achievement',
            'App\Notifications\ChallengeCommentedNotification' => 'comment',
            'App\Notifications\ChallengeLikedNotification' => 'like',
            'App\Notifications\NewFollowerNotification' => 'follower',
        ][$this->type];

        return [
            'id' => $this->id,
            'type' => $type,
            'data' => $this->data,
            'read_at' => $this->read_at,
            'created_at' => $this->created_at,
        ];
    }
}
