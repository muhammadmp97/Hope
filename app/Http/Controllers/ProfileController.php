<?php

namespace App\Http\Controllers;

use App\Actions\User\EditProfileAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        return $this->ok(
            UserResource::make($request->user())
        );
    }

    public function update(UpdateProfileRequest $request, EditProfileAction $editProfileAction)
    {
        $user = $editProfileAction->execute($request->user(), $request->validated());

        return $this->ok(
            UserResource::make($user)
        );
    }
}
