<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isLiked = $this->likes->contains(fn ($like) => $like->user->id === $request->user()->id);

        return [
            'id' => $this->id,
            'user' => TinyUserResource::make($this->user),
            'status' => $this->status,
            'text' => $this->text,
            'continued_at' => $this->continued_at,
            'is_liked' => $isLiked,
            'like_count' => $this->likes->count(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
