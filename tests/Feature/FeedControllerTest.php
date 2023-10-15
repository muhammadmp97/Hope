<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    public function setUp(): void
    {
        parent::setUp();

        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);

        $this->user = $this->signIn();
    }

    public function test_user_gets_following_challenges()
    {
        $userToFollow = User::factory()->create();

        $this->user
            ->following()
            ->attach($userToFollow->id);

        Challenge::factory()->count(3)->create(['user_id' => 2]);

        $this
            ->getJson('api/feed')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }
}
