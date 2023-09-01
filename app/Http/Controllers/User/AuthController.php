<?php

namespace App\Http\Controllers\User;

use App\Actions\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;

class AuthController extends Controller
{
    public function register(UserRegistrationRequest $request, CreateUserAction $createUserAction)
    {
        $createUserAction->execute($request);

        return $this->created();
    }
}
