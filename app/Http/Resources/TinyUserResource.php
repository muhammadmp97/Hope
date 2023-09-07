<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TinyUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nick_name' => $this->nick_name,
            'bio' => $this->bio,
            'avatar_url' => $this->avatar_url,
            'is_followed' => $this->isFollowedBy(request()->user()->id),
        ];
    }
}
