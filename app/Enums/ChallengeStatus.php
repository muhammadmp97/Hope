<?php

namespace App\Enums;

enum ChallengeStatus: string
{
    case ONGOING = 'ongoing';
    case STOPPED = 'stopped';
    case ABANDONED = 'abandoned';
    case COMPLETED = 'completed';
}
