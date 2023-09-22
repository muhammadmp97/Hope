<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserFollowingRecommendationTest extends TestCase
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

    public function test_user_can_gets_recommendation_list_contain_users_from_same_addiction_and_country()
    {
        $followers = User::factory()->count(5)->create();
        $this->user->following()->attach($followers->pluck('id'));
        User::factory()->create();
        $recommendations = User::factory()->count(5)->create([
            'country_id' => $this->user->country_id,
            'addiction_type' => $this->user->addiction_type,
        ]);

        $response = $this
            ->getJson("api/users/{$this->user->id}/following/recommendations");

        $response->assertOk();
        $this->assertCount(5, $response['data']);
        $this->assertEquals(
            $recommendations->pluck(['id', 'nike_name', 'avatar_url', 'bio']),
            collect($response['data'])->pluck(['id', 'nike_name', 'avatar_url', 'bio']),
        );
    }
}
