<?php

namespace App\Http\Controllers\Admin;

use App\Models\Batch;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\CoursePerStudent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends BaseController
{
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
        return $this->success($coursePerStudent,"Successfully created");
    }
    public function index()
    {
        return $this->success(Enrollment::with(['course','student'])->get(),"All enrollments");
    }
    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
