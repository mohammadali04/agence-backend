<?php
namespace Modules\Home\Routes;
use Illuminate\Support\Facades\Route;
use Modules\Home\Http\Controllers\Api\Admin\AdminFeatureController;
use Modules\Home\Http\Controllers\Api\Admin\AdminBannerController;

Route::prefix('api')->group(function () {
    Route::get('admin/features/all',[AdminFeatureController::class,'getFeatures']);
    Route::post('admin/features/store',[AdminFeatureController::class,'store']);
    Route::get('admin/features/{id}/show',[AdminFeatureController::class,'show']);
    Route::put('admin/features/{id}/update',[AdminFeatureController::class,'update']);
    Route::delete('admin/features/{id}/delete',[AdminFeatureController::class,'delete']);
});
Route::prefix('api')->group(function () {
    Route::get('admin/banners/all',[AdminBannerController::class,'getBanner']);
    Route::post('admin/banners/store',[AdminBannerController::class,'store']);
    Route::put('admin/banners/{id}/update',[AdminBannerController::class,'update']);
    Route::delete('admin/banners/{id}/delete',[AdminBannerController::class,'delete']);
});
