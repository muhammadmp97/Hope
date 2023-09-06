<?php

use App\Http\Controllers\CountriesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeCommentsController;
use App\Http\Controllers\ChallengeLikesController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\ContinueChallengeController;
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

Route::apiResource('challenges', ChallengesController::class)->only(['index', 'store', 'destroy']);
Route::post('challenges/{challenge}/continue', ContinueChallengeController::class);

Route::get('challenges/{challenge}/likes', [ChallengeLikesController::class, 'index']);
Route::post('challenges/{challenge}/likes', [ChallengeLikesController::class, 'store']);
Route::delete('challenges/{challenge}/likes', [ChallengeLikesController::class, 'destroy']);

Route::apiResource('challenges/{challenge}/comments', ChallengeCommentsController::class)->except(['show']);

Route::apiResource('users', UsersController::class)->only('index', 'show');

Route::get('countries', [CountriesController::class, 'index']);
