<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\CourseController;

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/courses',[CourseController::class,'index']);
    });
?>
