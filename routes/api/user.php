<?php

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/store', [UserController::class, 'store']);
Route::get('/:id', [UserController::class, 'show']);
Route::get('/', [UserController::class, 'index']);
Route::get('/me/{id}', [UserController::class, 'me']);