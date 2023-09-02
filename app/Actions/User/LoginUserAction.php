<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function execute($request): string
    {
        $user = User::firstWhere('email', $request->email);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            abort(401, 'User not found!');
        }

        return $user
            ->createToken($request->header('User-Agent'))
            ->plainTextToken;
    }
}
