<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChallengeCommentsController;
use App\Http\Controllers\ChallengeLikesController;
use App\Http\Controllers\ChallengesController;
use App\Http\Controllers\CommentLikesController;
use App\Http\Controllers\ContinueChallengeController;
use App\Http\Controllers\CountriesController;
use App\Http\Controllers\DeactivationRequestsController;
use App\Http\Controllers\FollowSuggestionsController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserAchievementsController;
use App\Http\Controllers\UserFollowersController;
use App\Http\Controllers\UserFollowingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
});

Route::get('notifications', [NotificationsController::class, 'index']);

Route::post('deactivate', [DeactivationRequestsController::class, 'store']);

Route::get('profile', [ProfileController::class, 'index']);
Route::patch('profile', [ProfileController::class, 'update']);

Route::apiResource('challenges', ChallengesController::class)->only(['index', 'store', 'destroy']);
Route::post('challenges/{challenge}/continue', ContinueChallengeController::class);

Route::get('challenges/{challenge}/likes', [ChallengeLikesController::class, 'index']);
Route::post('challenges/{challenge}/likes', [ChallengeLikesController::class, 'store']);
Route::delete('challenges/{challenge}/likes', [ChallengeLikesController::class, 'destroy']);

Route::apiResource('challenges/{challenge}/comments', ChallengeCommentsController::class)->except(['show']);

Route::get('comments/{comment}/likes', [CommentLikesController::class, 'index']);
Route::post('comments/{comment}/likes', [CommentLikesController::class, 'store']);
Route::delete('comments/{comment}/likes', [CommentLikesController::class, 'destroy']);

Route::prefix('users/{user}/following')
    ->group(function () {
        Route::get('/', [UserFollowingController::class, 'index']);
        Route::get('/recommendations', [UserFollowingController::class, 'recommendations']);
    });

Route::apiResource('users', UsersController::class)->only('index', 'show');
Route::get('users/{user}/following', [UserFollowingController::class, 'index']);
Route::get('users/{user}/followers', [UserFollowersController::class, 'index']);
Route::post('users/{user}/followers', [UserFollowersController::class, 'store']);
Route::delete('users/{user}/followers', [UserFollowersController::class, 'destroy']);
Route::get('users/{user}/achievements', [UserAchievementsController::class, 'index']);

Route::get('follow-suggestions', [FollowSuggestionsController::class, 'index']);

Route::post('reports', [ReportsController::class, 'store']);

Route::get('countries', [CountriesController::class, 'index']);
