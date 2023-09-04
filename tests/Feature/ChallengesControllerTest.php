<?php

namespace Tests\Feature;

use App\Enums\ChallengeStatus;
use App\Models\Challenge;
use App\Models\Country;
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

    public function test_user_creates_a_challenge()
    {
        $this
            ->postJson('api/challenges', [
                'text' => 'I keep fighting!',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('challenges', [
            'user_id' => 1,
            'status' => ChallengeStatus::ONGOING,
            'text' => 'I keep fighting!',
        ]);
    }

    public function test_user_cant_have_two_ongoing_challenges()
    {
        Challenge::factory()->create([
            'status' => ChallengeStatus::ONGOING,
        ]);

        $this
            ->postJson('api/challenges', [
                'text' => '',
            ])
            ->assertStatus(400);
    }
}
