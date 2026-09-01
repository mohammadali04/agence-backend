<?php
namespace Modules\Home\Routes;
use Illuminate\Routing\Route;
// routes/api.php
use Modules\Identity\Http\Api\Controllers\Admin\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('/user', [AuthController::class, 'user'])->middleware('auth:api');
Route::middleware('auth:api')->post('/refresh', [AuthController::class, 'refresh']);


