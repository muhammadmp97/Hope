<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    use RefreshDatabase;

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
    }

    public function test_user_profile_can_be_updated()
    {
        $user = $this->signIn();

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
                    'id' => $user->id,
                    'email' => $user->email,
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
