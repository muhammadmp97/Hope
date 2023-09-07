<?php

namespace App\Actions\User;

use App\Models\User;

class FollowUserAction
{
    public function execute(User $follower, $followingId): void
    {
        $userIsFollowed = $follower
            ->following()
            ->where('followed_id', $followingId)
            ->exists();

        if (! $userIsFollowed) {
            $follower
            ->following()
            ->attach($followingId);
        }
    }
}
