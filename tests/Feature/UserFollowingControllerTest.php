<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserFollowingControllerTest extends TestCase
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
