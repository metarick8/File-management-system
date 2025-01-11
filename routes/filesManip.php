<?php

use App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;


//don't forget authorization here:
Route::get('groups/{group:id}/files', [FileController::class, 'index'])->middleware('auth');



Route::prefix('files')->group(function () {

    Route::post('store', [FileController::class, 'store'])->middleware('auth');
    //show only not accepted files for a group admin

});






Route::get('testing', [FileController::class, 'testing']);
