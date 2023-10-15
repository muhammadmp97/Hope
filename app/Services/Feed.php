<?php

namespace App\Services;

use App\Models\Challenge;
use App\Models\User;

class Feed
{
    public function __construct(
        private $user = null
    ) {
    }

    public function get($perPage = 10)
    {
        $user = $this->user ?: request()->user();

        $followingIds = $user
            ->following()
            ->pluck('following_id');

        return Challenge::query()
            ->with(['user'])
            ->withCount(['likes', 'comments'])
            ->latest('continued_at')
            ->whereIn('user_id', $followingIds)
            ->paginate($perPage);
    }
}
