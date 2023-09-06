<?php

namespace App\Actions\Challenge;

use App\Models\Challenge;
use App\Models\Comment;
use App\Models\User;

class UpdateCommentAction
{
    public function execute(Comment $comment, array $data): Comment
    {
        $comment->update([
            'text' => $data['text'],
        ]);

        return $comment;
    }
}
