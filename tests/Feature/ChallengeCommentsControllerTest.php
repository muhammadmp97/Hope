<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Comment;
use App\Models\Country;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChallengeCommentsControllerTest extends TestCase
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

        Challenge::factory()->create();

        Challenge::query()
            ->first()
            ->comments()
            ->create([
                'user_id' => 1,
                'text' => 'Keep fighting, dude!',
            ]);
    }

    public function test_user_gets_comment_list()
    {

        $this->getJson('api/challenges/1/comments')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->user->id,
                        'user' => [
                            'id' => $this->user->id,
                            'nick_name' => $this->user->nick_name,
                            'bio' => $this->user->bio,
                            'avatar_url' => $this->user->avatar_url,
                        ],
                        'text' => 'Keep fighting, dude!',
                    ],
                ],
            ]);
    }

    public function test_user_leaves_a_comment()
    {
        $response = $this->postJson('api/challenges/1/comments', [
            'text' => 'Keep fighting, dude!',
        ]);

        $response
            ->assertCreated()
            ->assertJson([
                'data' => [
                    'text' => 'Keep fighting, dude!',
                ],
            ]);
    }

    public function test_user_edits_a_comment()
    {
        $response = $this->putJson('api/challenges/1/comments/1', [
            'text' => 'Keep fighting, man!',
        ]);

        $response
            ->assertOk()
            ->assertJson([
                'data' => [
                    'text' => 'Keep fighting, man!',
                ],
            ]);

        $this->assertDatabaseHas('comments', [
            'text' => 'Keep fighting, man!',
        ]);
    }

    public function test_user_cant_edit_other_people_comments()
    {
        $this->signIn();

        $this
            ->putJson('api/challenges/1/comments/1', [
                'text' => 'New text',
            ])
            ->assertStatus(403);
    }

    public function test_user_deletes_a_comment()
    {
        $this
            ->deleteJson('api/challenges/1/comments/1')
            ->assertOk();

        $this->assertDatabaseEmpty('comments');
    }

    public function test_user_cant_delete_other_people_comments()
    {
        $this->signIn();

        $this
            ->deleteJson('api/challenges/1/comments/1')
            ->assertStatus(403);
    }
}
