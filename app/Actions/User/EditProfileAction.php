<?php

namespace App\Actions\User;

use App\Models\User;

class EditProfileAction
{
    public function execute(User $user, $fields): User
    {
        $user->update($fields->validated());

        return $user;
    }
}
