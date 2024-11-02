<?php

use App\Http\Controllers\Stats\StatsController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StatsController::class, 'index']);