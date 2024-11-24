<?php

use App\Http\Controllers\Music\MusicController;
use Illuminate\Support\Facades\Route;

Route::post('/', [MusicController::class, 'store']);
Route::get('/search', [MusicController::class, 'search']);
Route::get('/', [MusicController::class, 'index']);
Route::get('/details', [MusicController::class, 'getDetails']);
Route::get('/details-channel', [MusicController::class, 'getDetailsChannel']);
Route::get('/next', [MusicController::class, 'nextMusic']);
Route::get('/adjust-queue', [MusicController::class, 'adjustMusicQueue']);
