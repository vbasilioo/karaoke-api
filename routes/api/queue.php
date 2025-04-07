<?php

use App\Http\Controllers\Queue\QueueController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth.api'])->group(function(){
    Route::get('/index', [QueueController::class, 'index']);
    Route::delete('/delete', [QueueController::class, 'destroy']);
});
