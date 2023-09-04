<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChallengeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user' => TinyUserResource::make($this->user),
            'status' => $this->status,
            'text' => $this->text,
            'continued_at' => $this->continued_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
