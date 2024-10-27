<?php

use App\Http\Controllers\Show\ShowController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.api'])->group(function(){
    Route::post('/', [ShowController::class, 'store']);
    Route::get('/', [ShowController::class, 'index']);
    Route::get('/{code_access}', [ShowController::class, 'show']);
});
