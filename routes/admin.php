<?php

use App\Http\Controllers\Admin\WeekController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\CareerController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CvFormController;
use App\Http\Controllers\Admin\ApplicationController;
use App\Http\Controllers\Admin\AssignmentController;
use App\Http\Controllers\Admin\InstructorController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\VideoController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    $user = $request->user();
    return User::where('id', $user->id)->with(['roles','image'])->first();
});

Route::apiResource('courses', CourseController::class);
Route::apiResource('applications', ApplicationController::class);
Route::apiResource('careers', CareerController::class);
Route::apiResource('cv-forms', CvFormController::class);
Route::post('images', [ImageController::class,'store']);
Route::post('files', [FileController::class,'store']);
Route::post('videos', [VideoController::class,'store']);
Route::post('applications/add-instructor', [ApplicationController::class,'addInstructor']);
Route::apiResource('instructors', InstructorController::class);
Route::apiResource('weeks', WeekController::class)->except(['index']);
Route::apiResource('batches', BatchController::class)->except(['index']);
Route::apiResource('lessons', LessonController::class)->except(['index']);
Route::apiResource('questions', QuestionController::class);
Route::apiResource('assignments', AssignmentController::class);
Route::get('batches/all/{course_id}', [BatchController::class,'index']);
Route::get('weeks/all/{batch_id}', [WeekController::class,'index']);
Route::get('lessons/all/{week_id}', [LessonController::class,'index']);
Route::apiResource('enrollments', EnrollmentController::class);
