<?php

use App\Http\Controllers\Show\ShowController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth.api'])->group(function () {
    Route::post('/store', [ShowController::class, 'store']);
    Route::get('/', [ShowController::class, 'index']);
    Route::get('/{code_access}', [ShowController::class, 'show']);
    Route::put('/{id}', [ShowController::class, 'update']);
    Route::delete('/delete/{id}', [ShowController::class, 'delete']);
    Route::patch('/restore/{id}', [ShowController::class, 'restore']);
});
