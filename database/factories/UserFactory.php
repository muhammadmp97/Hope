<?php

namespace Database\Factories;

use App\Enums\AddictionType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('12345678'),
            'nick_name' => fake()->name(),
            'bio' => fake()->text(60),
            'avatar_url' => fake()->imageUrl(),
            'addiction_type' => AddictionType::Unknown->value,
            'country_id' => 1,
            'birth_date' => fake()->date(max: '1999-01-01'),
        ];
    }
}
