<?php

namespace App\Listeners;

use App\Actions\Report\ReportAction;
use App\Events\CommentCreated;
use App\Models\Comment;
use App\Models\User;
use App\Services\AbuseDetection\AbuseDetector;
use Illuminate\Contracts\Queue\ShouldQueue;

class CheckCommentContent implements ShouldQueue
{
    public $delay = 60;

    public function __construct(
        public AbuseDetector $abuseDetector,
        public ReportAction $reportAction
    ) {}

    public function handle(CommentCreated $event): void
    {
        $isAbusive = $this
            ->abuseDetector
            ->check($event->comment->text);

        if ($isAbusive) {
            $hopeBot = User::firstWhere('email', config('hope.hope_bot_mail'));
            $this->reportAction->execute($hopeBot, [
                'reportable_id' => $event->comment->id,
                'reportable_type' => Comment::class,
                'text' => 'Abusive or hate-speech detected.',
            ]);
        }
    }
}
