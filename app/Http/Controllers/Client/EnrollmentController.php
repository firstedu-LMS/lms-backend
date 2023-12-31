<?php

namespace App\Http\Controllers\Client;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\CourseCompletion;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\client\EnrollmentRequest;

class EnrollmentController extends BaseController
{
    public function store(EnrollmentRequest $request)
    {
        $existEnrollmentForCurrentStudent = Enrollment::where('course_id', $request->course_id)->where('student_id', $request->student_id)->first();
        $isStudentAttendingThisCourse = CourseCompletion::where('course_id', $request->course_id)->where('student_id', $request->student_id)->first();
        if ($existEnrollmentForCurrentStudent || $isStudentAttendingThisCourse) {
            return $this->error(["message" => "Student already enrolled this course."], [], config('http_status_code.bad_request'));
        }
        $enrollment = Enrollment::create($request->validated());
        return $this->success($enrollment, "successfully created", config('http_status_code.created'));
    }
}