<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ImageController;
use Illuminate\Support\Facades\Route;



Route::apiResource('categories',CategoryController::class);
Route::apiResource('courses',CourseController::class);
Route::post('images',[ImageController::class,'store']);


?>
