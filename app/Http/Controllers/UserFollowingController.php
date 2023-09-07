<?php

namespace App\Http\Controllers;

use App\Http\Resources\TinyUserResource;
use App\Models\User;

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
}
