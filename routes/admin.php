<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use Illuminate\Support\Facades\Route;



Route::apiResource('categories',CategoryController::class);
Route::apiResource('courses',CourseController::class);



?>
