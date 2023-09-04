<?php

namespace App\Http\Controllers;

use App\Actions\Challenge\CreateChallengeAction;
use App\Http\Requests\CreateChallengeRequest;
use App\Http\Resources\ChallengeResource;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(CreateChallengeRequest $request, CreateChallengeAction $createChallengeAction)
    {
        $challenge = $createChallengeAction->execute($request->user(), $request->validated());

        return $this->created(
            ChallengeResource::make($challenge)
        );
    }
}
