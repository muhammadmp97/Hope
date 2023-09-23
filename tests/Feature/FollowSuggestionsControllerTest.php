<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FollowSuggestionsControllerTest extends TestCase
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

    public function test_user_can_get_suggestion_list()
    {
        $followers = User::factory()->count(5)->create();

        $this->user->following()->attach($followers->pluck('id'));

        User::factory()->create();

        User::factory()->count(5)->create([
            'country_id' => $this->user->country_id,
            'addiction_type' => $this->user->addiction_type,
        ]);

        $this
            ->getJson('api/follow-suggestions')
            ->assertOk()
            ->assertJsonCount(5, 'data');
    }

    public function test_user_can_not_get_suggestion_for_him_self()
    {
        $this
            ->getJson('api/follow-suggestions')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    public function test_user_can_not_get_suggestion_for_his_followings()
    {
        $followers = User::factory()->count(5)->create();

        $this->user->following()->attach($followers->pluck('id'));

        $this
            ->getJson('api/follow-suggestions')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }
}
