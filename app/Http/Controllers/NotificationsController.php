<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $notifications = request()
            ->user()
            ->notifications()
            ->paginate();

        request()
            ->user()
            ->unreadNotifications
            ->markAsRead();

        return $this->ok(
            NotificationResource::collection($notifications)
        );
    }
}
