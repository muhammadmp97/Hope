<?php

namespace App\Http\Controllers;

use App\Actions\User\ChangePasswordAction;
use App\Actions\User\CreateUserAction;
use App\Actions\User\LoginUserAction;
use App\Actions\User\LogoutUserAction;
use App\Exceptions\UserNotFoundException;
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
        $createUserAction->execute($request->validated());

        return $this->created();
    }

    public function login(UserLoginRequest $request, LoginUserAction $loginUserAction)
    {
        try {
            $token = $loginUserAction->execute($request->validated());
        } catch (UserNotFoundException) {
            return $this->unauthorized([
                'message' => 'Authentication failed',
            ]);
        }

        return $this->ok(
            UserTokenResource::make($token)
        );
    }

    public function logout(Request $request, LogoutUserAction $logoutUserAction)
    {
        $logoutUserAction->execute($request->user());

        return $this->ok();
    }

    public function changePassword(ChangePasswordRequest $request, ChangePasswordAction $changePasswordAction)
    {
        $changePasswordAction->execute($request->user(), $request->validated());

        return $this->ok();
    }
}
