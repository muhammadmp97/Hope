<?php

namespace App\Services;

use Illuminate\Support\Arr;

class Achievement
{
    public static function getByPassedDays(int $days): ?array
    {
        $achievements = config('hope.achievements');

        return Arr::first($achievements, function ($achievement) use ($days) {
            return isset($achievement['after_n_days']) && $achievement['after_n_days'] === $days;
        });
    }

    public static function getById(int $id): array
    {
        return config('hope.achievements')[$id];
    }
}
