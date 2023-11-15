<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Instructor\InstructorController;
use App\Http\Controllers\Instructor\CourseController;

Route::get('profile/{instructor}', [InstructorController::class, 'profile']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/courses',[CourseController::class,'index']);
});
?>

