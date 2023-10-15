<?php

namespace Tests\Feature;

use App\Notifications\NewFollowerNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_gets_notifications_list()
    {
        $anotherUser = $this->user = $this->signIn();

        $this
            ->user
            ->notify(new NewFollowerNotification($anotherUser));

        $this
            ->getJson('api/notifications')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'data',
                        'read_at',
                        'created_at',
                    ],
                ],
            ]);
    }
}
