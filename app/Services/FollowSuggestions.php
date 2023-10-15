<?php

namespace App\Services;

use App\Models\User;

class FollowSuggestions
{
    public function __construct(
        private $user = null
    ) {
    }

    public function suggest($count = 5)
    {
        $user = $this->user ?: request()->user();

        $followingIds = $user
            ->following()
            ->pluck('following_id');

        return User::query()
            ->select('id', 'nick_name', 'avatar_url', 'bio')
            ->whereNotIn('id', $followingIds)
            ->whereNot('id', $user->id)
            ->where('country_id', '=', $user->country_id)
            ->where('addiction_type', '=', $user->addiction_type)
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
}
