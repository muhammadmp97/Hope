<?php

namespace Database\Factories;

use App\Enums\ChallengeStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ChallengeFactory extends Factory
{
    public function definition(): array
    {
        $challengeStatus = array_column(ChallengeStatus::cases(), 'value');

        $createdAt = now()->subDays(rand(10, 30));

        return [
            'user_id' => User::first()->id,
            'status' => Arr::random($challengeStatus),
            'text' => rand(0, 1) == 1 ? $this->faker->text(160) : '',
            'continued_at' => $createdAt->addDays(rand(0, 10)),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ];
    }
}
