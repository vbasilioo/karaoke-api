<?php

use App\Builder\ReturnApi;
use Illuminate\Support\Facades\Route;

Route::get('/', function(){
    return ReturnApi::success(null, 'API rodando com sucesso.');
});

Route::prefix('/auth')->group(base_path('routes/api/auth.php'));
Route::prefix('/admin')->group(base_path('routes/api/admin.php'));
Route::prefix('/music')->group(base_path('routes/api/music.php'));
Route::prefix('/show')->group(base_path('routes/api/show.php'));
Route::prefix('/user')->group(base_path('routes/api/user.php'));
Route::prefix('/queue')->group(base_path('routes/api/queue.php'));
Route::prefix('/stats')->group(base_path('routes/api/stats.php'));