<?php

namespace App\Http\Controllers\Admin;

use App\Models\Week;
use App\Models\Batch;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\CourseCompletion;
use App\Models\CoursePerStudent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\WeekCompletion;
use CheckToDeleteService;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends BaseController
{
    public function index()
    {
        return $this->success(Enrollment::with(['course','student'])->get(),"All enrollments");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
        "course_id" => "required",
        "student_id" => "required",
        "batch_id" => "required"
        ]);

        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation failed",config('http_status_code.unprocessable_content'));
        }
        
        $coursePerStudent = new CoursePerStudent();
        $coursePerStudent->course_id = $request->course_id;
        $coursePerStudent->batch_id = $request->batch_id;
        $coursePerStudent->student_id = $request->student_id;
        $coursePerStudent->save();
        $enrollment = Enrollment::where('course_id',$request->course_id)->where('student_id',$request->student_id)->first();
        $enrollment->delete();
        $weeks = Week::where('course_id',$request->course_id)->where('batch_id',$request->batch_id)->get();
        $weekcount = $weeks->count();
        $courseCompletion = new CourseCompletion();
        $courseCompletion->week_count = $weekcount;
        $courseCompletion->student_id = $request->student_id;
        $courseCompletion->course_id = $request->course_id;
        $courseCompletion->save();
        foreach($weeks as $week) {
            $lessonCount = Lesson::where('week_id',$week->id)->count();
            $lessonCompletion = new WeekCompletion();
            $lessonCompletion->lesson_count = $lessonCount;
            $lessonCompletion->student_id = $request->student_id;
            $lessonCompletion->course_id = $request->course_id;
            $lessonCompletion->batch_id = $request->batch_id;
            $lessonCompletion->week_id = $week->id;
            $lessonCompletion->save();
        }
        return $this->success($coursePerStudent,"Successfully created");
    }
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
    // public function destroy(Enrollment $enrollment)
    // {
    //     $enrollment->delete();
    //     return $this->success([], 'deleted', config('http_status_code.no_content'));
    // }
}
