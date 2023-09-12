<?php

namespace Tests\Feature;

use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeactivationRequestsControllerTest extends TestCase
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

    public function test_user_requests_account_deactivation()
    {
        Sanctum::actingAs($this->user);
        $this->user->currentAccessToken()->shouldReceive('delete')->once();

        $this
            ->postJson('api/deactivate')
            ->assertOk();

        $this->assertDatabaseHas('deactivation_requests', [
            'user_id' => $this->user->id,
        ]);
    }
}
