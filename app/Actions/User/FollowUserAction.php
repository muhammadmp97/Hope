<?php

namespace App\Actions\User;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Symfony\Component\HttpKernel\Exception\HttpException;

class FollowUserAction
{
    public function execute(User $follower, User $following): void
    {
        if ($follower->is($following)) {
            throw new HttpException(400, 'No one follows himself!');
        }

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
