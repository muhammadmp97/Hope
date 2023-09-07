<?php

namespace App\Actions\User;

use App\Models\User;

class UnfollowUserAction
{
    public function execute(User $follower, $followingId): void
    {
        $follower
            ->following()
            ->detach($followingId);
    }
}
