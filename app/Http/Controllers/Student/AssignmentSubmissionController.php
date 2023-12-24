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
use Psy\Readline\Hoa\Console;

class AssignmentSubmissionController extends BaseController
{
    public function index($course_id , $batch_id)
    {
        $yangon_time = Carbon::now('Asia/Yangon');
        $data = Assignment::where('course_id' , $course_id)->where('batch_id' , $batch_id)->get();
        $assignments = [];
        foreach ($data as $d) {
                if (strtotime($d->test_date." ".$d->test_time) <= strtotime($yangon_time->format('Y-m-d H:i:s'))) {
                    $d->over_test_date = true;
                } else {
                    $d->over_test_date = false;
                }
                $asi = AssignmentScore::where('assignment_id' , $d->id)->where('student_id' , $this->student()->id)->first();
                if ($asi) {
                    $d->finish = true;
                } else {
                    $d->finish = false;
                }

                $assignments[] = $d;
            }
        return $this->success($assignments , 'Assignments For Student' , config('http_status_code.ok'));
    }

    public function show($id)
    {
        $data = Assignment::where('id' , $id)->with('file')->first();
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
