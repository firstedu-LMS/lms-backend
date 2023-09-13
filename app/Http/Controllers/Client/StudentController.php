<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CoursePerStudent;
use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $student = Student::where('user_id', $user->id)->with(['user' => function ($query) {
            $query->with(['image','roles']);
        }])->first();
        return $this->success($student, 'student info');
    }

    public function update(Request $request, $student)
    {
        $student = Student::where('id', $student)->first();
        foreach ($request->all() as $key => $value) {
            $student->$key = $value;
        }
        $student->update();
        return $this->success($student, "student info updated");
    }
    public function enrollment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'student_id' => 'required'
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation failed",config('http_status_code.unprocessable_content'));
        }
        $enrollment =new Enrollment($request->all());
        $enrollment->save();
        return $this->success($enrollment,"successfully created",config('http_status_code.created'));
    }
    public function course_per_students($student)
    {
        return $this->success(CoursePerStudent::where('student_id',$student)->with(['batch' => function($query) {
            $query->with('course');
        },'student'])->get(),'All datas that student enroll');
    }
}
