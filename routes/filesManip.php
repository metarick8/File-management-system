<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


Route::get('groups/{group:id}/files', [FileController::class, 'index'])->middleware(['auth', 'checkGroupMembership']);

Route::prefix('files')->middleware('auth')->group(function () {
    Route::post('store', [FileController::class, 'store']);
    Route::post('check-in', [FileController::class, 'checkin'])->middleware('setTransactionIsolation');
    Route::post('check-out', [FileController::class, 'checkout']);
    Route::post('/{file:id}/accept', [FileController::class, 'accept']);
});
Route::get('tosql', [FileController::class, 'showQuery']);






Route::get('testing', [FileController::class, 'testing']);
