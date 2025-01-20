<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/filesManip.php';

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout');
    Route::get('refresh', 'refresh');
});

Route::prefix('group')->group(function () {
    Route::post('create', [GroupController::class, 'create']);
    Route::get('list', [GroupController::class, 'listGroupsForUser']);
    Route::get('{id}', [GroupController::class, "show"]);
});

Route::prefix('invite')->group(function () {
    Route::post('send', [InvitationController::class, 'sendInvite']);
    Route::post('accept', [InvitationController::class, 'invitationResponse']);
    Route::get('show', [InvitationController::class, "show"]);
});

Route::post('user/search', [UserController::class, "search"]);


