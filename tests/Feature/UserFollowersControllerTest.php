<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFollowersControllerTest extends TestCase
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

        User::factory()->create();
    }

    public function test_user_gets_follower_list()
    {
        $this->user
            ->following()
            ->attach(2);

        $this
            ->getJson('api/users/2/followers')
            ->assertOk()
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

    public function test_user_follows_others()
    {
        $this
            ->postJson('api/users/2/followers')
            ->assertOk();

        $this
            ->getJson('api/users/2')
            ->assertJson([
                'data' => [
                    'followers_count' => 1,
                    'is_followed' => true,
                ],
            ]);

        $this->assertDatabaseHas('followers', [
            'follower_id' => 1,
            'following_id' => 2,
        ]);
    }

    public function test_user_unfollows_following_user()
    {
        $this->user
            ->following()
            ->attach(2);

        $this
            ->deleteJson('api/users/2/followers')
            ->assertOk();

        $this->assertDatabaseEmpty('followers');
    }
}
