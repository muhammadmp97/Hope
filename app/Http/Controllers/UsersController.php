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
        $users = User::paginate();

        return $this->ok(
            PublicProfileResource::collection($users)
        );
    }

    public function show(User $user)
    {
        return $this->ok(
            PublicProfileResource::make($user)
        );
    }
}
