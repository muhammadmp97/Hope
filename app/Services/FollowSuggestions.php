<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class FollowSuggestions
{
    public function __construct(
        private $user = null
    ) {
    }

    public function suggest($count = 5)
    {
        $user = $this->user ?: request()->user();

        $followingIds = DB::table('followers')
            ->select('following_id')
            ->where('follower_id', $user->id)
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
