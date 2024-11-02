<?php

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/', [UserController::class, 'store']);
Route::get('/:id', [UserController::class, 'show']);
Route::get('/', [UserController::class, 'index']);