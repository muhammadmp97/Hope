<?php

namespace App\Http\Resources;

use App\Services\Achievement;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAchievementResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $achievement = Achievement::getById($this->achievement_id);

        return [
            'name' => $achievement['name'],
            'description' => $achievement['description'],
            'count' => $this->count,
        ];
    }
}
