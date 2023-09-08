<?php

namespace App\Http\Controllers;

use App\Actions\Challenge\LikeChallengeAction;
use App\Actions\Challenge\UnlikeChallengeAction;
use App\Http\Resources\TinyUserResource;
use App\Models\Challenge;

class ChallengeLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Challenge $challenge)
    {
        $challenge->load('likes');

        $users = $challenge->likes->map(fn ($like) => $like->user);

        return $this->ok(
            TinyUserResource::collection($users)
        );
    }

    public function store(Challenge $challenge, LikeChallengeAction $likeChallengeAction)
    {
        $likeChallengeAction->execute(request()->user(), $challenge);

        return $this->ok();
    }

    public function destroy(Challenge $challenge, UnlikeChallengeAction $unlikeChallengeAction)
    {
        $unlikeChallengeAction->execute(request()->user(), $challenge);

        return $this->ok();
    }
}
