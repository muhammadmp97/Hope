<?php

namespace App\Actions\User;

class LogoutUserAction
{
    public function execute($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
