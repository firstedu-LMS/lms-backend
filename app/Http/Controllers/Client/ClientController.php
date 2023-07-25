<?php

namespace App\Http\Controllers\Client;

use App\Events\CareerCreated;
use App\Events\CourseCreated;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CareerResource;
use App\Http\Resources\CourseResource;
use App\Models\Career;
use App\Models\Course;
use Illuminate\Support\Facades\Event;

class ClientController extends BaseController
{
    public function courses(){

        Event::dispatch(new CourseCreated());

        $course = cache('courses',function (){
            return   Course::with('image')->get();
        });

        //If the frontend team want only the required fields ,use the GetLatestForCourseResource
        return $this->success(CourseResource::collection($course),'latest courses');
    }

    public function careers(){

        Event::dispatch(new CareerCreated());

        $careers = cache('careers',function (){
            return   Career::all();
        });

        //If the frontend team want one the required fields ,use the GetLatestForCourseResource
        return $this->success(CareerResource::collection($careers),'careers');
    }
}
