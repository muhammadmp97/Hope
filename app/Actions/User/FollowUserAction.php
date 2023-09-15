<?php

namespace App\Actions\User;

use App\Models\User;
use App\Notifications\NewFollowerNotification;

class FollowUserAction
{
    public function execute(User $follower, User $following): void
    {
        $userIsFollowed = $follower
            ->following()
            ->where('following_id', $following->id)
            ->exists();

        if (! $userIsFollowed) {
            $follower
                ->following()
                ->attach($following->id);

            $following->notify(new NewFollowerNotification($follower));
        }
    }
}
