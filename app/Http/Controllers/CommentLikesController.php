<?php

namespace App\Http\Controllers;

use App\Actions\Comment\LikeCommentAction;
use App\Actions\Comment\UnlikeCommentAction;
use App\Http\Resources\TinyUserResource;
use App\Models\Comment;

class CommentLikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Comment $comment)
    {
        $comment->load('likes');

        $users = $comment->likes->map(fn ($like) => $like->user);

        return $this->ok(
            TinyUserResource::collection($users)
        );
    }

    public function store(Comment $comment, LikeCommentAction $likeCommentAction)
    {
        $likeCommentAction->execute(request()->user(), $comment);

        return $this->ok();
    }

    public function destroy(Comment $comment, UnlikeCommentAction $unlikeCommentAction)
    {
        $unlikeCommentAction->execute(request()->user(), $comment);

        return $this->ok();
    }
}
