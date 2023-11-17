<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Instructor;
use Illuminate\Http\Request;

class InstructorController extends BaseController
{
    public function instructor()
    {
        return Instructor::where('user_id',Auth::id())->first();
    }
    public function profile() {
        $instructor = $this->instructor();
        $currentCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 1
        ])->pluck('course_id')->unique()->count();
        $finishedCourse = 1; //default value due to unknown logic
        return $this->success([
           'instructor' => $instructor->with(['cv','user'])->first(),
           'currentCourse' => $currentCourse,
           'finishedCourse' => $finishedCourse
        ],'Instructor Profile');
    }
}