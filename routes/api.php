<?php

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::get('profile', [ProfileController::class, 'index']);
Route::patch('profile', [ProfileController::class, 'update']);

Route::apiResource('users', UsersController::class)->only('index', 'show');

Route::get('countries', [CountriesController::class, 'index']);
