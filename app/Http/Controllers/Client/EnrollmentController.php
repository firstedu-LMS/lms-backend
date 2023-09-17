<?php

namespace App\Http\Controllers\Client;

use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'student_id' => 'required'
        ]);
        
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation failed",config('http_status_code.unprocessable_content'));
        }

        $existEnrollmentForCurrentStudent = Enrollment::where('student_id',$request->student_id)->first();

        if ($existEnrollmentForCurrentStudent) {
            return response()->json([
                "data" => [],
                "message" => "This student has already entrolled this course!"
            ],400);
        }

        $enrollment =new Enrollment($request->all());
        $enrollment->save();
        return $this->success($enrollment,"successfully created",config('http_status_code.created'));
    }
}
