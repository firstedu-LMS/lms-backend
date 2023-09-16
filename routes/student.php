<?php

use App\Http\Controllers\Client\StudentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [StudentController::class, 'profile']);
    Route::patch('/user/{student}', [StudentController::class, 'update']);
    Route::post('/enrollments',[StudentController::class, 'enrollment']);
    Route::get('/course-per-students/{student_id}', [StudentController::class,'course_per_students']);
    Route::post('/lesson-completions', [StudentController::class, 'lessonCompletion']);
});
