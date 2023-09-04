<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UsersControllerTest extends TestCase
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

        User::factory()->count(2)->create();
    }

    public function test_user_can_get_users_list()
    {
        $this->getJson('api/users')
            ->assertOk()
            ->assertJsonCount(3, 'data');
    }

    public function test_user_can_get_a_user_profile_data()
    {
        $this
            ->getJson('api/users/2')
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'nick_name',
                    'bio',
                    'avatar_url',
                    'country',
                    'addiction_type',
                    'is_recovered',
                    'score',
                    'birth_date',
                    'created_at',
                    'updated_at',
                ],
            ]);
    }
}
