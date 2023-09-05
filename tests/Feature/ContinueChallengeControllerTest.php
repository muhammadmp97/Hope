<?php

namespace Tests\Feature;

use App\Enums\ChallengeStatus;
use App\Models\Challenge;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContinueChallengeControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);

        $this->signIn();
    }

    public function test_user_should_wait_a_day_to_continue_the_challenge()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::ONGOING->value,
            'continued_at' => now()->subDay()->addMinute(),
            'created_at' => now()->subDay()->addMinute(),
        ]);

        $this->postJson('api/challenges/1/continue')
            ->assertStatus(400);
    }

    public function test_user_cant_continue_non_ongoing_challenges()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::STOPPED->value,
        ]);

        $this->postJson('api/challenges/1/continue')
            ->assertStatus(400);
    }

    public function test_user_cant_continue_others_challenges()
    {
        User::factory()->create();

        Challenge::factory()->create([
            'user_id' => 2,
            'status' => ChallengeStatus::ONGOING->value,
        ]);

        $this->postJson('api/challenges/1/continue')
            ->assertStatus(403);
    }

    public function test_user_continues_the_challenge()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::ONGOING->value,
            'continued_at' => now()->subDays(3),
            'created_at' => now()->subDays(3),
        ]);

        $this->postJson('api/challenges/1/continue')
            ->assertStatus(200);

        $challenge = Challenge::first();
        $this->assertTrue($challenge->continued_at->diffInDays() === 0);
        $this->assertTrue($challenge->updated_at->diffInDays() > 0);
    }
}
