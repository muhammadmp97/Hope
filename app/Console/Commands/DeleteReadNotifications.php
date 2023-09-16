<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeleteReadNotifications extends Command
{
    protected $signature = 'app:delete-seen-notifications';

    protected $description = 'Delete seen notifications';

    public function handle()
    {
        DB::table('notifications')
            ->whereNotNull('read_at')
            ->where('updated_at', '<', now()->subMonths(2))
            ->delete();

        return $this->comment('Done!');
    }
}
