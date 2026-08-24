<?php
namespace Modules\Home\Routes;
use Illuminate\Support\Facades\Route;
use Modules\Blog\Http\Controllers\Api\Admin\BlogController;
use Modules\Home\Http\Controllers\Api\Admin\FeatureController;

Route::prefix('api')->group(function () {
    Route::get('admin/blogs/all',[BlogController::class,'getBlogs']);
    Route::post('admin/blogs/store',[BlogController::class,'store']);
    Route::get('admin/blogs/{id}/show',[BlogController::class,'show']);
    Route::post('admin/blogs/{id}/update',[BlogController::class,'update']);
    Route::delete('admin/blogs/{id}/delete',[BlogController::class,'delete']);
});
