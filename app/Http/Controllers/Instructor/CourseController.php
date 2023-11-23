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
            $courses[0] = [
                "course_id" => $data[0]->course_id,
                "course_name" => $data[0]->course->name,
                "image" => $data[0]->course->image->image,
                "batch_id" => $data[0]->id,
                "batch_name" => $data[0]->name,
                "instructor_id" => $data[0]->instructor_id
            ];
        }
        return $this->success($courses , "courses");
    }
}