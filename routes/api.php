<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Client\CareerController;
use App\Http\Controllers\Client\CourseController;
use App\Http\Controllers\Client\EnrollmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return User::where('id', $user->id)->with(['roles','image'])->first();
});



Route::get('courses', [CourseController::class,'index']);
Route::get('careers', [CareerController::class,'index']);
Route::get('courses/{id}', [CourseController::class,'show']);
Route::get('careers/{id}', [CareerController::class,'show']);
Route::post('register', [AuthController::class,'register'])->name('register');
Route::post('login', [AuthController::class,'login']);
Route::post('logout', [AuthController::class,'logout'])->middleware('auth:sanctum');
Route::post('register/profile', [ImageController::class,'store']);
Route::post('enrollments', [EnrollmentController::class,'store']);