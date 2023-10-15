<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFollowingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_following_list()
    {
        $userToFollow = User::factory()->create();

        $this->user
            ->following()
            ->attach($userToFollow->id);

        $this
            ->getJson('api/users/1/following')
            ->assertOk()
            ->assertJson([
                'data' => [
                    [
                        'id' => $userToFollow->id,
                        'nick_name' => $userToFollow->nick_name,
                        'bio' => $userToFollow->bio,
                        'avatar_url' => $userToFollow->avatar_url,
                    ],
                ],
            ]);
    }
}
