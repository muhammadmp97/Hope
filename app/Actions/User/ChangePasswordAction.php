<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordAction
{
    public function execute(User $user, $data): void
    {
        if (! Hash::check($data['old_password'], $user->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Old password is wrong!',
            ]);
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);
    }
}
