<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);
    }

    public function test_user_registers(): void
    {
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

    public function test_user_logs_in()
    {
        $user = User::factory()->create();

        $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => '12345678',
        ])->assertOk();
    }

    public function test_wrong_credentials_dont_work()
    {
        $user = User::factory()->create();

        $this->postJson('api/auth/login', [
            'email' => $user->email,
            'password' => 'password',
        ])->assertStatus(401);
    }

    public function test_user_changes_password_using_old_password()
    {
        $user = $this->signIn();

        $this->postJson('api/auth/change-password', [
            'old_password' => '12345678',
            'password' => 'password',
        ])->assertOk();

        $this->assertTrue(Hash::check('password', $user->password));
    }

    public function test_user_needs_old_password_for_changing_password()
    {
        $this->signIn();

        $this->postJson('api/auth/change-password', [
            'old_password' => '1234',
            'password' => 'password',
        ])->assertJsonValidationErrorFor('old_password');
    }
}
