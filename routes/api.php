<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function (){
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::get('logout', 'logout');
    Route::get('refresh', 'refresh');
});
//Route::middleware('auth:api')->group(function () {
    Route::post('group/create', [GroupController::class, 'create']);
    Route::get('group/list', [GroupController::class, 'showGroupsForUser']);
    Route::post('group/invite', [InvitationController::class, 'sendInvite']);
    Route::post('group/acceptInvite', [InvitationController::class, 'invitationResponse']);
    Route::post('user/search', [UserController::class, "search"]);
    Route::get('group/{id}', [GroupController::class, "showGroup"]);
    Route::get('invite/list', [InvitationController::class, 'showInvitationsForUser']);
///});
