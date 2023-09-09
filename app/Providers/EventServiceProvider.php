<?php

namespace App\Providers;

use App\Events\ChallengeContinued;
use App\Events\ChallengeCreated;
use App\Events\CommentCreated;
use App\Listeners\ChallengeAchievementsListener;
use App\Listeners\CheckCommentContent;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        ChallengeCreated::class => [
            ChallengeAchievementsListener::class,
        ],

        ChallengeContinued::class => [
            ChallengeAchievementsListener::class,
        ],

        CommentCreated::class => [
            CheckCommentContent::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
