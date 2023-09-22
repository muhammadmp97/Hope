<?php

namespace App\Http\Controllers;

use App\Http\Resources\TinyUserResource;
use App\Services\FollowSuggestions;

class FollowSuggestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(FollowSuggestions $followSuggestionsService)
    {
        $suggestions = $followSuggestionsService->suggest();

        return $this->ok(
            TinyUserResource::collection($suggestions)
        );
    }
}
