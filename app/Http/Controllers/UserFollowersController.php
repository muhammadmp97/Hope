<?php

namespace App\Http\Controllers;

use App\Actions\User\FollowUserAction;
use App\Actions\User\UnfollowUserAction;
use App\Http\Resources\TinyUserResource;
use App\Models\User;

class UserFollowersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(User $user)
    {
        $followers = $user
            ->followers()
            ->orderBy('id', 'desc')
            ->paginate();

        return $this->ok(
            TinyUserResource::collection($followers)
        );
    }

    public function store($followingId, FollowUserAction $followUserAction)
    {
        $followUserAction->execute(request()->user(), User::findOrFail($followingId));

        return $this->ok();
    }

    public function destroy($followingId, UnfollowUserAction $unfollowUserAction)
    {
        $unfollowUserAction->execute(request()->user(), $followingId);

        return $this->ok();
    }
}
