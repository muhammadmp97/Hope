<?php

namespace Tests\Feature\User;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registers(): void
    {
        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);

        $this->postJson('api/auth/register', [
            'email' => 'johndoe@gmail.com',
            'password' => '12345678',
            'nick_name' => 'John',
            'country_id' => 1,
        ])->assertCreated();

        $this->assertDatabaseHas('users', [
            'email' => 'johndoe@gmail.com',
        ]);
    }
}
