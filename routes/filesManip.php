<?php

use App\Http\Controllers\FileController;
use App\Models\FileInfo;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('groups/{group:id}/files', [FileController::class, 'index'])->middleware(['auth', 'checkGroupMembership']);

Route::prefix('files')->middleware('auth')->group(function () {
    Route::post('store', [FileController::class, 'store']);
    Route::post('check-in', [FileController::class, 'checkin'])->middleware('setTransactionIsolation');
    Route::post('check-out', [FileController::class, 'checkout']);
    Route::post('/{file:id}/accept', [FileController::class, 'accept']);
});
Route::get('tosql', [FileController::class, 'showQuery']);





Route::get('testing2', function () {
    return 'hi2';
});
Route::get('testing', function () {
    sleep(5);
    return 'hi';
    // return 'hi there';
    // return Storage::disk('local')->download(FileInfo::first()->path);
    // return 'hi';
});
