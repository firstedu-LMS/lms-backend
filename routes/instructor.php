<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\InstructorController;

Route::get('profile/{instructor}', [InstructorController::class, 'profile']);