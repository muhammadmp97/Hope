<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsControllerTest extends TestCase
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

        Challenge::factory()->create();

        Challenge::query()
            ->first()
            ->comments()
            ->create([
                'user_id' => 1,
                'text' => 'Keep fighting, dude!',
            ]);
    }

    public function test_a_user_reports_a_comment()
    {
        $this
            ->postJson('api/reports', [
                'reportable_type' => 'comment',
                'reportable_id' => 1,
                'text' => 'This comment is offensive',
            ])
            ->assertCreated();

        $this->assertDatabaseHas('reports', [
            'text' => 'This comment is offensive',
        ]);
    }
}
