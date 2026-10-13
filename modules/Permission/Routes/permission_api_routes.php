<?php
namespace Modules\Permission\Routes;
use Illuminate\Support\Facades\Route;
use modules\Permission\Http\Controllers\Api\Admin\PermissionController;
use modules\Permission\Http\Controllers\Api\Admin\RoleController;

Route::prefix('api')->group(function () {
    Route::get('admin/permissions/all',[PermissionController::class,'permissions']);
    Route::get('admin/permissions/{id}/get',[PermissionController::class,'getPermission']);
    Route::post('admin/permissions/store',[PermissionController::class,'store']);
    Route::put('admin/permissions/{id}/update',[PermissionController::class,'update']);
    Route::delete('admin/permissions/{id}/delete',[PermissionController::class,'delete']);
});
Route::prefix('api')->group(function () {
    Route::get('admin/roles/all',[RoleController::class,'roles']);
    Route::get('admin/roles/{id}/get',[RoleController::class,'getRole']);
    Route::post('admin/roles/store',[RoleController::class,'store']);
    Route::put('admin/roles/{id}/update',[RoleController::class,'update']);
    Route::delete('admin/roles/{id}/delete',[RoleController::class,'delete']);
});
