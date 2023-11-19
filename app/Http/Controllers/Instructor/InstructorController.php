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
    public function profile(Instructor $instructor) {
        $currentCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 1
        ])->pluck('course_id')->unique()->count();
        $finishedCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 0
        ])->count();
        return $this->success([
           'instructor' => $instructor->with(['cv','user'])->first(),
           'currentCourse' => $currentCourse,
           'finishedCourse' => $finishedCourse
        ],'Instructor Profile');
    }
}
