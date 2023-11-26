<?php

use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\WeekController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Instructor\InstructorController;


Route::middleware('auth:sanctum')->group(function () {
        Route::controller(InstructorController::class)->group(function () {
            Route::get('courses','getInstructorCourses');
            Route::get('profile',  'profile');
            Route::patch('profile-update',  'update');
            Route::patch('profile-name-update',  'updateName');
            Route::post('profile-image-update',  'updateImage');
            Route::post('change-password',  'changePassword');
        });
        Route::controller(LessonController::class)->group(function(){
            Route::post('lessons','store');
            Route::get('lessons/{week_id}','index');
        });
        Route::controller(WeekController::class)->group(function(){
            Route::get('courses/{batch_id}/weeks', 'index');
            Route::post('courses/{batch_id}/weeks' , 'store');
        });
      
    });
?>