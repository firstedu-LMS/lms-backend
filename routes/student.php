<?php

use App\Http\Controllers\Student\AssignmentSubmissionController;
use App\Http\Controllers\Student\QuestionController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Student\StudentController;


 Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', [StudentController::class, 'profile']);
    Route::get('/course-per-students/{student_id}', [StudentController::class, 'course_per_students']);
    Route::get('/get-lessons-of-week/{student_id}/{course_id}/{batch_id}/{week_id}', [StudentController::class, 'studentGetlessonsOfWeek']);
    Route::get('/get-weeks-of-course/{student_id}/{course_id}/{batch_id}', [StudentController::class, 'studentGetweeksOfCourse']);
    Route::get('/question/{student_id}/{lesson_id}',[QuestionController::class,'getLessonQuestions']);

    Route::post('/question/submissions',[QuestionController::class,'submission']);
    Route::post('/submissions', [AssignmentSubmissionController::class, 'submission']);
    Route::post('/lesson-completions', [StudentController::class, 'lessonCompletion']);


    Route::patch('/user/{student}', [StudentController::class, 'update']);
    Route::get('/assignment/{course_id}/{batch_id}' , [AssignmentSubmissionController::class, 'index']);
    Route::get('/assignments/{id}' , [AssignmentSubmissionController::class, 'show']);
});