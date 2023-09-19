<?php

namespace App\Actions\User;

use App\Exceptions\UserNotFoundException;
use App\Models\DeactivationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginUserAction
{
    public function execute(array $data): string
    {
        $user = User::firstWhere('email', $data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new UserNotFoundException();
        }

        // Logging into an account could save it from deletion
        DeactivationRequest::where('user_id', $user->id)->delete();

        return $user
            ->createToken(request()->header('User-Agent', 'Unkown User Agent'))
            ->plainTextToken;
    }
}
