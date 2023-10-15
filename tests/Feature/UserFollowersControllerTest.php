<?php

namespace Tests\Feature;

use App\Models\User;
use App\Notifications\NewFollowerNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserFollowersControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

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
        Notification::fake();

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

        Notification::assertSentTo(User::find(2), NewFollowerNotification::class);
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

    public function test_user_cannot_follow_himself()
    {
        $this
            ->postJson('api/users/1/followers')
            ->assertStatus(400);
    }
}
