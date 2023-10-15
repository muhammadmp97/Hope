<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Notifications\CommentLikedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class CommentLikesControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;

    private $comment;

    public function setUp(): void
    {
        parent::setUp();

        $challenge = Challenge::factory()->create();

        $this->comment = $challenge
            ->comments()
            ->create([
                'user_id' => 1,
                'text' => 'Keep fighting, dude!',
            ]);
    }

    public function test_user_gets_comment_like_list()
    {
        $this
            ->comment
            ->likes()
            ->create([
                'user_id' => 1,
            ]);

        $this->getJson('api/comments/1/likes')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJson([
                'data' => [
                    [
                        'id' => $this->user->id,
                        'nick_name' => $this->user->nick_name,
                        'bio' => $this->user->bio,
                        'avatar_url' => $this->user->avatar_url,
                    ],
                ],
            ]);
    }

    public function test_user_likes_a_comment()
    {
        Notification::fake();

        $this->postJson('api/comments/1/likes')
            ->assertOk();

        $this->assertEquals(1, $this->comment->likes()->count());

        Notification::assertSentTo($this->user, CommentLikedNotification::class);
    }

    public function test_user_unlikes_a_comment()
    {
        $this
            ->comment
            ->likes()
            ->create([
                'user_id' => 1,
            ]);

        $this->deleteJson('api/comments/1/likes')
            ->assertOk();

        $this->assertEquals(0, $this->comment->likes()->count());
    }
}
