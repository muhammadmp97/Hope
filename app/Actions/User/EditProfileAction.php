<?php

namespace App\Actions\User;

use App\Models\User;

class EditProfileAction
{
    public function execute(User $user, array $data): User
    {
        $user->update($data);

        return $user;
    }
}
