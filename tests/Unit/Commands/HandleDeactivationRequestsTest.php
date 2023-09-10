<?php

namespace Tests\Unit;

use App\Actions\User\RequestDeactivationAction;
use App\Models\Challenge;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HandleDeactivationRequestsTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);

        $this->user = $this->signIn();
    }

    public function test_deletes_user_data(): void
    {
        Challenge::factory()->create();

        Challenge::query()
            ->first()
            ->comments()
            ->create([
                'user_id' => 1,
                'text' => 'Keep fighting, dude!',
            ]);

        Challenge::query()
            ->first()
            ->likes()
            ->create([
                'user_id' => 1,
            ]);

        app(RequestDeactivationAction::class)->execute($this->user);

        $this->travelTo(now()->addDays(11));

        $this->artisan('app:handle-deactivation-requests');

        $this->assertDatabaseCount('deactivation_requests', 0);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('challenges', 0);
        $this->assertDatabaseCount('comments', 0);
        $this->assertDatabaseCount('likes', 0);
    }
}
