<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\AssignmentScore;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;

class AssignmentController extends BaseController
{
    public function index($course_id)
    {
        $assignmentScore = AssignmentScore::all();
        return $assignmentScore;
    }
}