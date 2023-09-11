<?php

namespace App\Console\Commands;

use App\Models\DeactivationRequest;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class HandleDeactivationRequests extends Command
{
    protected $signature = 'app:handle-deactivation-requests';

    protected $description = 'Handles deactivation requests';

    public function handle()
    {
        $userIds = DeactivationRequest::query()
            ->where('created_at', '<', now()->subDays(10))
            ->pluck('user_id');
        
        DB::transaction(function () use ($userIds) {
            $users = User::query()
            ->whereIn('id', $userIds)
            ->get();

        foreach ($users as $user) {
            $user->delete();
        }

        DeactivationRequest::query()
            ->whereIn('user_id', $userIds)
            ->delete();
        });

        return $this->comment('Done!');
    }
}
