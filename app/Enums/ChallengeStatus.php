<?php

namespace App\Enums;

enum ChallengeStatus: string
{
    case ONGOING = 'ongoing';
    case SURRENDERED = 'surrendered';
    case ABANDONED = 'abandoned';
    case COMPLETED = 'completed';
}
