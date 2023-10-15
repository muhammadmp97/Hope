<?php

namespace Tests\Feature;

use App\Models\Challenge;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_user_reports_a_comment()
    {
        Challenge::factory()->create();

        Challenge::query()
            ->first()
            ->comments()
            ->create([
                'user_id' => 1,
                'text' => 'Keep fighting, dude!',
            ]);

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
