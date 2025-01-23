<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ReportController;
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
});

Route::prefix('user')->group(function () {
    Route::post('search', [UserController::class, "search"]);
    Route::get('/notifications', [UserController::class, "notifications"]);
});

Route::get('files/{file:id}/report', [ReportController::class, 'indexFile']);
Route::get('group/{group:id}/report', [ReportController::class, 'indexGroup']);
Route::get('testing', [PDFController::class, "generatePDF"]);




