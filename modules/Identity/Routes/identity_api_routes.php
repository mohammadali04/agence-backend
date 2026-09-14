<?php

namespace Modules\Home\Routes;

use Illuminate\Support\Facades\Route;

// routes/api.php
use Modules\Identity\Http\Api\Controllers\Admin\AuthController;

Route::get('api/admin/users/all', [AuthController::class, 'users']);
Route::post('api/admin/users/register', [AuthController::class, 'register']);
Route::post('api/admin/users/login', [AuthController::class, 'login']);
Route::post('api/admin/users/logout', [AuthController::class, 'logout'])->middleware('auth:api');
Route::get('api/admin/users/{id}/get', [AuthController::class, 'user'])->middleware('auth:api');
Route::delete('api/admin/users/{id}/delete', [AuthController::class, 'delete'])->middleware('auth:api');
Route::post('api/refresh', [AuthController::class, 'refresh']);


