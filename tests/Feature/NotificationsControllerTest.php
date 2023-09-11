<?php

namespace Tests\Feature;

use App\Models\Challenge;
use App\Models\Country;
use App\Models\User;
use App\Notifications\ChallengeCommentedNotification;
use App\Notifications\NewFollowerNotification;
use App\Services\AbuseDetection\AbuseDetector;
use App\Services\AbuseDetection\Komprehend;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class NotificationsControllerTest extends TestCase
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
