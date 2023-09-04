<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
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

        Country::create([
            'code' => 'IQ',
            'name' => 'Iraq',
        ]);

        $this->user = $this->signIn();
    }

    public function test_user_can_get_the_profile()
    {
        $this->getJson('api/profile')
            ->assertOk()
            ->assertJson([
                'data' => [
                    'nick_name' => $this->user->nick_name,
                    'bio' => $this->user->bio,
                    'is_recovered' => false,
                    'birth_date' => $this->user->birth_date,
                    'id' => $this->user->id,
                    'email' => $this->user->email,
                    'addiction_type' => 0,
                    'country' => [
                        'id' => 1,
                        'code' => 'GB',
                        'name' => 'United Kingdom',
                    ],
                ],
            ]);
    }

    public function test_user_profile_can_be_updated()
    {
        $data = [
            'nick_name' => 'Blue Rose',
            'bio' => 'This is a sample text.',
            'country_id' => 2,
            'is_recovered' => true,
            'birth_date' => '1999-09-09',
        ];

        $response = $this->patchJson('api/profile', $data);
        
        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'nick_name' => 'Blue Rose',
                    'bio' => 'This is a sample text.',
                    'is_recovered' => true,
                    'birth_date' => '1999-09-09',
                    'id' => $this->user->id,
                    'email' => $this->user->email,
                    'addiction_type' => 0,
                    'country' => [
                        'id' => 2,
                        'code' => 'IQ',
                        'name' => 'Iraq',
                    ],
                ],
            ]);

        $this->assertDatabaseHas('users', $data);
    }
}
