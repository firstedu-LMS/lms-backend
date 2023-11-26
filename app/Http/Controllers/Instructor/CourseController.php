<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Batch;
use App\Models\Instructor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BatchResource;
use App\Http\Controllers\BaseController;

class CourseController extends BaseController
{
    public function instructor()
    {
        return Instructor::where('user_id',Auth::id())->first();
    }
    public function index()
    {
        $data = Batch::where('instructor_id',$this->instructor()->id)->with('course.image')->get();
        $courses = [];
        for ($i=0; $i < count($data); $i++) { 
            $courses[$i] = [
                "course_id" => $data[$i]->course_id,
                "course_name" => $data[$i]->course->name,
                "image" => $data[$i]->course->image->image,
                "batch_id" => $data[$i]->id,
                "batch_name" => $data[$i]->name,
                "instructor_id" => $data[$i]->instructor_id
            ];
        }
        return $this->success($courses , "courses");
    }
}