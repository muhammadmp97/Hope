<?php

namespace App\Http\Controllers;

use App\Actions\User\EditProfileAction;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function update(UpdateProfileRequest $request, EditProfileAction $editProfileAction)
    {
        $user = $editProfileAction->execute($request->user(), $request);

        return $this->ok(
            UserResource::make($user)
        );
    }
}
