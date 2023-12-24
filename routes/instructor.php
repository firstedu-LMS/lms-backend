<?php

use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\WeekController;
use App\Http\Controllers\Admin\VideoController;

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
            Route::patch('lessons/{lesson_id}','update');
            Route::delete('lessons/{lesson_id}','destroy');
            Route::get('lessons/{lesson_id}','show');
            Route::post('lessons','store');
            Route::get('week/lessons/{week_id}','getInstructorLesson');
        });

        Route::get('questions/all/{lesson_id}', [QuestionController::class, 'index']);
        Route::apiResource('questions', QuestionController::class)->except('index');
        Route::post('videos', [VideoController::class, 'store']);
    
        Route::controller(WeekController::class)->group(function(){
            Route::get('courses/{batch_id}/weeks', 'index');
            Route::post('courses/{batch_id}/weeks' , 'store');
        });
      
    });

