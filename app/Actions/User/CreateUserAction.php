<?php

namespace App\Actions\User;

use App\Enums\AddictionType;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(array $data): User
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'nick_name' => $data['nick_name'],
            'country_id' => $data['country_id'],
            'addiction_type' => AddictionType::Unknown,
        ]);
    }
}
