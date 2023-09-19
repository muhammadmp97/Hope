<?php

namespace App\Http\Controllers;

use App\Actions\Challenge\CreateChallengeAction;
use App\Actions\Challenge\StopChallengeAction;
use App\Exceptions\UserHaveUnCompletedChallengeException;
use App\Http\Requests\CreateChallengeRequest;
use App\Http\Resources\ChallengeResource;
use App\Models\Challenge;
use Illuminate\Validation\UnauthorizedException;

class ChallengesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $challenges = Challenge::query()
            ->with(['user'])
            ->withCount(['likes', 'comments'])
            ->latest('continued_at')
            ->byUserId(request()->user_id)
            ->paginate();

        return $this->ok(
            ChallengeResource::collection($challenges)
        );
    }

    public function store(CreateChallengeRequest $request, CreateChallengeAction $createChallengeAction)
    {
        try {
            $challenge = $createChallengeAction->execute($request->user(), $request->validated());
        } catch (UserHaveUnCompletedChallengeException) {
            return $this->badRequest([
                'message' => 'You have uncompleted challenge',
            ]);
        }

        return $this->created(
            ChallengeResource::make($challenge)
        );
    }

    public function destroy(Challenge $challenge, StopChallengeAction $stopChallengeAction)
    {
        if ($challenge->user_id !== request()->user()->id) {
            throw new UnauthorizedException();
        }

        $stopChallengeAction->execute($challenge);

        return $this->ok();
    }
}
