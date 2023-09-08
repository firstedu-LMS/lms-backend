<?php

use App\Http\Controllers\Client\StudentController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/profiles/{student}', [StudentController::class,'show']);
