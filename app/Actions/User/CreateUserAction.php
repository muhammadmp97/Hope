<?php

namespace App\Actions\User;

use App\Enums\AddictionType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute($user)
    {
        User::create([
            'email' => $user->email,
            'password' => Hash::make($user->password),
            'nick_name' => $user->nick_name,
            'country_id' => $user->country_id,
            'addiction_type' => AddictionType::Unknown,
        ]);
    }
}
