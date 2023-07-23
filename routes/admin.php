<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ImageController;
use Illuminate\Support\Facades\Route;


Route::apiResource('courses',CourseController::class);
Route::apiResource('applications',ApplicationController::class);
Route::apiResource('careers',CareerController::class);
Route::post('images',[ImageController::class,'store']);


?>
