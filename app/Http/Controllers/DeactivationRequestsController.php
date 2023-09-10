<?php

namespace App\Http\Controllers;

use App\Actions\User\LogoutUserAction;
use App\Actions\User\RequestDeactivationAction;

class DeactivationRequestsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function store(RequestDeactivationAction $requestDeactivationAction, LogoutUserAction $logoutUserAction)
    {
        $requestDeactivationAction->execute(request()->user());

        $logoutUserAction->execute(request()->user());

        $this->ok();
    }
}
