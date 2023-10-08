<?php

namespace App\Http\Controllers\Client;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\client\EnrollmentRequest;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    public function store(EnrollmentRequest $request)
    {
        $existEnrollmentForCurrentStudent = Enrollment::where('student_id',$request->student_id)->where('course_id' , $request->course_id)->first();

        if ($existEnrollmentForCurrentStudent) {
            return response()->json([
                "data" => [],
                "message" => "This student has already entrolled this course!"
            ],400);
        }

        $enrollment = Enrollment::create($request->validated());
        return $this->success($enrollment,"successfully created",config('http_status_code.created'));
    }
}
