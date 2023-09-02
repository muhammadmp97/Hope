<?php

namespace App\Actions\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ChangePasswordAction
{
    public function execute($request): void
    {
        if (! Hash::check($request->old_password, $request->user()->password)) {
            throw ValidationException::withMessages([
                'old_password' => 'Old password is wrong!',
            ]);
        }

        $request
            ->user()
            ->update([
                'password' => Hash::make($request->password)
            ]);
    }
}
