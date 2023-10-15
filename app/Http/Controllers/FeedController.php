<?php

namespace App\Http\Controllers;

use App\Http\Resources\ChallengeResource;
use App\Services\Feed;

class FeedController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Feed $feedService)
    {
        $challenges = $feedService->get();
        
        return $this->ok(
            ChallengeResource::collection($challenges)
        );
    }
}
