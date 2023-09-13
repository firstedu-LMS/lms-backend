<?php

use App\Http\Controllers\Client\StudentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::middleware('auth:sanctum')->group(function () {

// });
Route::get('/profile', [StudentController::class, 'profile']);
Route::patch('/profile/{student}', [StudentController::class, 'update']);
Route::post('/enrollment',[StudentController::class, 'enrollment']);
