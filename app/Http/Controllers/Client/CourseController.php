<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CourseController extends BaseController
{
    public function index()
    {
        if (Cache::has('courses')) {
            $course = Cache::get('courses');
        } else {
            $course = Cache::rememberForever('courses', function () {
                return Course::with('image')->get();
            });
        }
        //If the frontend team want only the required fields ,use the GetLatestForCourseResource
        return $this->success(CourseResource::collection($course), 'latest courses');
    }

    public function show($id)
    {
        $course =  Course::where('id', $id)->first();
        return $this->success(new CourseResource($course), 'course show');
    }
}
