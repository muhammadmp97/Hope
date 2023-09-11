<?php

namespace Tests\Feature;

use App\Actions\Challenge\ContinueChallengeAction;
use App\Actions\Challenge\CreateChallengeAction;
use App\Models\Country;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class UserAchievementsControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $challenge;
    
    private CreateChallengeAction $createChallengeAction;
    private ContinueChallengeAction $continueChallengeAction;

    public function setUp(): void
    {
        parent::setUp();

        Country::create([
            'code' => 'GB',
            'name' => 'United Kingdom',
        ]);

        $this->user = $this->signIn();

        $this->createChallengeAction = new CreateChallengeAction();
        $this->continueChallengeAction = new ContinueChallengeAction();
    }

    public function test_user_can_have_achievments()
    {
        Notification::fake();

        $this->travelTo('2022-01-01 12:00:00');

        $challenge = $this
            ->createChallengeAction
            ->execute($this->user, [
                'text' => 'Hello!',
            ]);

        $this->travelTo('2022-01-06 12:00:00');

        $this->continueChallengeAction->execute($challenge);

        $this->assertDatabaseCount('user_achievements', 2);

        $this
            ->getJson('api/users/1/achievements')
            ->assertJson([
                'data' => [
                    [
                        'name' => 'hopeful',
                        'description' => 'The user earns this after starting a challenge',
                        'count' => 1,
                    ],
                    [
                        'name' => 'honored',
                        'description' => 'The user earns this after five days of endurance in the challenge',
                        'count' => 1,
                    ],
                ],
            ]);

        $this->assertEquals(15, User::first()->score);

        Notification::assertCount(2);
    }
}
