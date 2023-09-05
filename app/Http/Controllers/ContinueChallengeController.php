<?php

namespace App\Http\Controllers;

use App\Actions\Challenge\ContinueChallengeAction;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use Illuminate\Validation\UnauthorizedException;

class ContinueChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(Challenge $challenge, ContinueChallengeAction $continueChallengeAction)
    {
        if ($challenge->user_id !== request()->user()->id) {
            throw new UnauthorizedException();
        }

        $challenge = $continueChallengeAction->execute($challenge);

        return $this->ok(
            ChallengeResource::make($challenge)
        );
    }
}
