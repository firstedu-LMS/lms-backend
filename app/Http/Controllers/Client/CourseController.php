<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Batch;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends BaseController
{
    public function index()
    {
        return $this->success(CourseResource::collection($course), 'latest courses');
    }

    public function show($id)
    {
        $course =  Course::where('id', $id)->first();
        return $this->success(new CourseResource($course), 'course show');
    }
}
