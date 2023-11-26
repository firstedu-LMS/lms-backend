<?php

use App\Http\Controllers\Admin\WeekController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Instructor\InstructorController;


Route::middleware('auth:sanctum')->group(function () {
        Route::get('courses',[InstructorController::class,'getInstructorCourses']);
        Route::get('profile', [InstructorController::class, 'profile']);
        Route::patch('profile-update', [InstructorController::class, 'update']);
        Route::patch('profile-name-update', [InstructorController::class, 'updateName']);
        Route::post('profile-image-update', [InstructorController::class, 'updateImage']);
        Route::post('change-password', [InstructorController::class, 'changePassword']);
        Route::get('courses/{batch_id}/weeks', [WeekController::class , 'index']);
        Route::post('courses/{batch_id}/weeks' , [WeekController::class , 'store']);
    });
?>