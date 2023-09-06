<?php

namespace App\Console\Commands;

use App\Enums\ChallengeStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CloseAbandonedChallenges extends Command
{
    protected $signature = 'app:close-abandoned-challenges';

    protected $description = 'Closes abandoned challenges';

    public function handle()
    {
        $deadline = config('hope.abandoned_challenges_deadline');

        DB::table('challenges')
            ->where('status', ChallengeStatus::ONGOING->value)
            ->where('continued_at', '<', now()->subDays($deadline))
            ->update([
                'status' => ChallengeStatus::ABANDONED->value,
            ]);

        return $this->comment('Done!');
    }
}
