<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\AssignmentScore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;

class AssignmentController extends BaseController
{
    public function student()
    {
        return Student::where('user_id',Auth::id())->first();
    }
    public function index($course_id)
    {
        $assignmentScore = AssignmentScore::where('course_id',$course_id)->where('student_id',$this->student()->id)->with(['course','student','assignment','student.user'])->get();
        return $this->success($assignmentScore , [] , config('http_status_code.ok') );
    }
}