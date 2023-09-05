<?php

namespace Tests\Feature;

use App\Enums\ChallengeStatus;
use App\Models\Challenge;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengesControllerTest extends TestCase
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

    public function test_user_gets_his_challenges()
    {
        Challenge::factory()->count(3)->create();

        $this
            ->getJson('api/challenges?user_id=1')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_user_creates_a_challenge()
    {
        $this
            ->postJson('api/challenges', [
                'text' => 'I keep fighting!',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('challenges', [
            'user_id' => 1,
            'status' => ChallengeStatus::ONGOING->value,
            'text' => 'I keep fighting!',
        ]);
    }

    public function test_user_cant_have_two_ongoing_challenges()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::ONGOING->value,
        ]);

        $this
            ->postJson('api/challenges', [
                'text' => '',
            ])
            ->assertStatus(400);
    }

    public function test_user_stops_a_challenge()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::ONGOING->value,
        ]);

        $this
            ->deleteJson('api/challenges/1')
            ->assertStatus(200);

        $this->assertDatabaseMissing('challenges', [
            'status' => ChallengeStatus::ONGOING->value,
        ]);
    }

    public function test_user_cant_stop_others_challenges()
    {
        User::factory()->create();

        Challenge::factory()->create([
            'user_id' => 2,
            'status' => ChallengeStatus::ONGOING->value,
        ]);

        $this
            ->deleteJson('api/challenges/1')
            ->assertStatus(403);
    }

    public function test_user_cant_stop_non_ongoing_challenges()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::STOPPED->value,
        ]);

        $this
            ->deleteJson('api/challenges/1')
            ->assertStatus(400);
    }
}
