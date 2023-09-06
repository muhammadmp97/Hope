<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengeLikesControllerTest extends TestCase
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

        Challenge::factory()->create();
    }

    public function test_user_gets_like_list()
    {
        Challenge::query()
            ->first()
            ->likes()
            ->create([
                'user_id' => 1,
            ]);

        $this->getJson('api/challenges/1/likes')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->user->id,
                        'nick_name' => $this->user->nick_name,
                        'bio' => $this->user->bio,
                        'avatar_url' => $this->user->avatar_url,
                    ],
                ],
            ]);
    }

    public function test_user_likes_a_challenge()
    {
        $this->postJson('api/challenges/1/likes')
            ->assertCreated();

            $this->postJson('api/challenges/1/likes')
            ->assertCreated();
        
        $this->assertEquals(1, Challenge::first()->likes()->count());
    }

    public function test_user_unlikes_a_challenge()
    {
        Challenge::query()
            ->first()
            ->likes()
            ->create([
                'user_id' => 1,
            ]);

        $this->deleteJson('api/challenges/1/likes')
            ->assertOk();
        
        $this->assertEquals(0, Challenge::first()->likes()->count());
    }
}
