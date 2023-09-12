<?php

namespace App\Services;

use Illuminate\Support\Arr;

class Achievement
{
    public static function getByPassedDays(int $days): ?array
    {
        $achievements = config('hope.achievements');

        $achievement = Arr::first($achievements, fn ($achievement) => $achievement['after_n_days'] === $days);

        return $achievement;
    }

    public static function getById(int $id): array
    {
        return config('hope.achievements')[$id];
    }
}
