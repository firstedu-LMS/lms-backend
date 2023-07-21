<?php

namespace App\Http\Controllers\Client;

use App\Events\CourseCreated;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CourseResource;
use App\Http\Resources\GetLatestFourCoursesResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;

class ClientController extends BaseController
{
    public function getLatestFourCources(){
        Event::dispatch(new CourseCreated());

        $course = cache('courses',function (){
            return  Course::latest()->take(4)->with('image')->get();
        });

        //If the frontend team want one the required fields ,use the GetLatestForCourseResource
        return $this->success(CourseResource::collection($course),'latest courses');
    }
}
