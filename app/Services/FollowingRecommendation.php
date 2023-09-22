<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class FollowingRecommendation
{
    public function __construct(
        private User $user,
    ) {
    }

    public function recommend($count = 5)
    {
        $followingIds = DB::table('followers')
            ->select('following_id')
            ->where('follower_id', $this->user->id)
            ->pluck('following_id');

        return User::query()
            ->select('id', 'nick_name', 'avatar_url', 'bio')
            ->whereNotIn('id', $followingIds)
            ->whereNot('id', $this->user->id)
            ->where('country_id', '=', $this->user->country_id)
            ->where('addiction_type', '=', $this->user->addiction_type)
            ->inRandomOrder()
            ->limit($count)
            ->get();
    }
}
