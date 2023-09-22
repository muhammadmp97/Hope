<?php

namespace App\Http\Controllers;

use App\Http\Resources\TinyUserResource;
use App\Http\Resources\UserRecommendationResource;
use App\Models\User;
use App\Services\FollowingRecommendation;

class UserFollowingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(User $user)
    {
        $following = $user
            ->following()
            ->orderBy('id', 'desc')
            ->paginate();

        return $this->ok(
            TinyUserResource::collection($following)
        );
    }

    public function recommendations(User $user)
    {
        $recommendations = (new FollowingRecommendation($user))
            ->recommend();

        return $this->ok(
            UserRecommendationResource::collection($recommendations)
        );
    }
}
