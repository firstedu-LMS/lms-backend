<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Instructor\CourseController;


Route::middleware('auth:sanctum')->group(function () {
    Route::get('courses',[CourseController::class,'index']);
    Route::get('profile', [InstructorController::class, 'profile']);
    Route::patch('profile-update', [InstructorController::class, 'update']);
    Route::patch('profile-name-update', [InstructorController::class, 'updateName']);
    Route::post('profile-image-update', [InstructorController::class, 'updateImage']);
});
?>