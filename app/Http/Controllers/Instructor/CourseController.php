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
        $data = Batch::where('instructor_id',$this->instructor()->id)->get();
        return $this->success(BatchResource::collection($data),"instructor courses");
    }
}