<?php

namespace App\Actions\User;

use App\Models\DeactivationRequest;
use App\Models\User;

class RequestDeactivationAction
{
    public function execute(User $user): void
    {
        DeactivationRequest::create([
            'user_id' => $user->id,
        ]);
    }
}
