<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserAchievementResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserAchievementsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(User $user)
    {
        $achievments = $user
            ->achievements()
            ->select('achievement_id', DB::raw('count(achievement_id) as count'))
            ->groupBy('achievement_id')
            ->get();

        return $this->ok(
            UserAchievementResource::collection($achievments)
        );
    }
}
