<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\SubmissionRequest;
use App\Models\Assignment;
use App\Models\AssignmentScore;
use App\Models\CoursePerStudent;
use Carbon\Carbon;

class AssignmentSubmissionController extends BaseController
{
    public function index()
    {
        $yangon_time = Carbon::now('Asia/Yangon');
        $data = CoursePerStudent::where('student_id', $this->student()->id)->get();
        $assignments = [];  
        foreach ($data as $d) {
            $ass = Assignment::where('course_id', $d->course_id)->where('batch_id', $d->batch_id)->first();
                if (strtotime($ass->test_date." ".$ass->test_time) <= strtotime($yangon_time->format('Y-m-d H:i:s'))) {
                    $ass->over_test_date = true;
                } else {
                    $ass->over_test_date = false;
                }   
                $asi = AssignmentScore::where('assignment_id' , $ass->id)->where('student_id' , $this->student()->id)->first();
                if ($asi) {
                    $ass->finish = true;
                } else {
                    $ass->finish = false;
                }
    
                $assignments[] = $ass;
            }
        return $this->success($assignments , 'Assignments For Student' , config('http_status_code.ok'));
    }
    

    public function show($id)
    {
        $data = Assignment::where('id' , $id)->first();
        return $this->success($data , '' , config('http_status_code.ok'));
    }


    public function student()
    {
        return Student::where('user_id', Auth::id())->first();
    }
    public function submission(SubmissionRequest $req)
    {
        Submission::create($req->validated() + ["student_id" => $this->student()->id]);
        return $this->success([], "Created submission", config('http_status_code.created'));
    }
}