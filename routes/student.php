<?php

use App\Http\Controllers\Client\StudentController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/profile',[StudentController::class, 'profile']);
