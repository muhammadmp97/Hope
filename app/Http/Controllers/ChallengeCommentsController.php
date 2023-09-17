<?php

namespace App\Http\Controllers;

use App\Actions\Challenge\CreateCommentAction;
use App\Actions\Challenge\UpdateCommentAction;
use App\Http\Requests\CreateCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Challenge;
use App\Models\Comment;
use Illuminate\Validation\UnauthorizedException;

class ChallengeCommentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Challenge $challenge)
    {
        $comments = $challenge
            ->comments()
            ->with(['user'])
            ->orderBy('id', 'desc')
            ->paginate();

        return $this->ok(
            CommentResource::collection($comments)
        );
    }

    public function store(CreateCommentRequest $request, Challenge $challenge, CreateCommentAction $createCommentAction)
    {
        $comment = $createCommentAction->execute($request->user(), $challenge, $request->validated());

        return $this->created(
            CommentResource::make($comment)
        );
    }

    public function update(UpdateCommentRequest $request, $challenge, Comment $comment, UpdateCommentAction $updateCommentAction)
    {
        if ($comment->user_id !== request()->user()->id) {
            throw new UnauthorizedException();
        }

        $comment = $updateCommentAction->execute($comment, $request->validated());

        return $this->ok(
            CommentResource::make($comment)
        );
    }

    public function destroy($challenge, Comment $comment)
    {
        if ($comment->user_id !== request()->user()->id) {
            throw new UnauthorizedException();
        }

        $comment->delete();

        return $this->ok();
    }
}
