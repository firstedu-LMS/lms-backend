<?php

use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CvFormController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ImageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AddInstructorController;

Route::apiResource('courses',CourseController::class);
Route::apiResource('applications',ApplicationController::class);
Route::post('applications',[ApplicationController::class,'store']);
Route::apiResource('careers',CareerController::class);
Route::apiResource('applicatons',ApplicationController::class);
Route::apiResource('cv-forms',CvFormController::class);
Route::post('images',[ImageController::class,'store']);
Route::post('files',[FileController::class,'store']);
Route::post('instructors',[AddInstructorController::class,'store']);



?>
