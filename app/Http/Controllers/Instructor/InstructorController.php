<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Models\CourseCompletion;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class InstructorController extends BaseController
{
    public function instructor()
    {
        return Instructor::where('user_id',Auth::id())->with(['cv','user'])->first();
    }
    public function profile() {
        $instructor = $this->instructor();
        $currentCourse = Batch::where([
            'instructor_id' => $instructor->id,
            'status' => 1
        ])->pluck('course_id')->unique()->count();
        $finishedCourse = 1; //default value due to unknown logic
        return $this->success([
           'instructor' => $instructor,
           'currentCourse' => $currentCourse,
           'finishedCourse' => $finishedCourse
        ],'Instructor Profile');
    }
}
