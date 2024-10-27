<?php

use App\Http\Controllers\Admin\AdministratorController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AdministratorController::class, 'store']);

Route::middleware(['auth.api'])->group(function(){
    Route::get('/', [AdministratorController::class, 'index']);
});