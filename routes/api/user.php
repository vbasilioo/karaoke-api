<?php

use App\Http\Controllers\Users\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/', [UserController::class, 'store']);
Route::get('/', [UserController::class, 'show']);
