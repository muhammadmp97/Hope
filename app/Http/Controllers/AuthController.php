<?php

namespace App\Http\Controllers;

use App\Actions\User\ChangePasswordAction;
use App\Actions\User\CreateUserAction;
use App\Actions\User\LoginUserAction;
use App\Actions\User\LogoutUserAction;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegistrationRequest;
use App\Http\Resources\UserTokenResource;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['logout', 'changePassword']);
    }

    public function register(UserRegistrationRequest $request, CreateUserAction $createUserAction)
    {
        $createUserAction->execute($request);

        return $this->created();
    }

    public function login(UserLoginRequest $request, LoginUserAction $loginUserAction)
    {
        $token = $loginUserAction->execute($request);

        return $this->ok(
            UserTokenResource::make($token)
        );
    }

    public function logout(Request $request, LogoutUserAction $logoutUserAction)
    {
        $logoutUserAction->execute($request);

        return $this->ok();
    }

    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $changePasswordAction)
    {
        $changePasswordAction->execute($request);

        return $this->ok();
    }
}
