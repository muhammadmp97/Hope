<?php

namespace Database\Factories;

use App\Enums\AddictionType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('12345678'),
            'nick_name' => fake()->name(),
            'bio' => fake()->text(60),
            'avatar_url' => fake()->imageUrl(),
            'addiction_type' => AddictionType::Unknown,
            'country_id' => 1,
            'birth_date' => fake()->date(max: '1999-01-01'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
