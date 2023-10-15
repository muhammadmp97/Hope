<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class DeactivationRequestsControllerTest extends TestCase
{
    use RefreshDatabase;

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
