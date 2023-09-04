<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nick_name' => $this->nick_name,
            'bio' => $this->bio,
            'avatar_url' => $this->avatar_url,
            'country' => CountryResource::make($this->country),
            'addiction_type' => $this->addiction_type,
            'is_recovered' => $this->is_recovered,
            'score' => $this->score,
            'birth_date' => $this->birth_date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
