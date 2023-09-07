<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicProfileResource;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $users = User::query()
            ->withCount(['followers', 'following'])
            ->paginate();

        return $this->ok(
            PublicProfileResource::collection($users)
        );
    }

    public function show(User $user)
    {
        $user->loadCount(['followers', 'following']);

        return $this->ok(
            PublicProfileResource::make($user)
        );
    }
}
