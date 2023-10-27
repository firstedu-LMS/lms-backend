<?php

namespace App\Http\Controllers\Student;

use App\Models\Student;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\BaseController;
use App\Http\Requests\SubmissionRequest;

class AssignmentSubmissionController extends BaseController
{
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