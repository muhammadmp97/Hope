<?php

namespace App\Services\AbuseDetection;

interface AbuseDetector
{
    public function check(string $text): bool;
}
