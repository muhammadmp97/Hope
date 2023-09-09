<?php

namespace App\Events;

use App\Models\Challenge;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ChallengeContinued
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Challenge $challenge
    ) {}
}
