<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([], function(){
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/login-temporary', [AuthController::class, 'temporaryLogin']);
});

Route::middleware(['auth.api'])->group(function(){
    Route::get('/me', [AuthController::class, 'me']);
});
