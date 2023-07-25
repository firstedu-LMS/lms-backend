<?php

namespace App\Http\Controllers\Client;

use App\Events\CareerCreated;
use App\Events\CourseCreated;
use App\Http\Controllers\BaseController;
use App\Http\Resources\CareerResource;
use App\Http\Resources\CourseResource;
use App\Models\Career;
use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class ClientController extends BaseController
{

    public function courseShow($id){
        $course =  Course::where('id',$id)->first();
        return $this->success(new CourseResource($course),'course show');
    }

    public function careerShow($id){
        $career =  Career::where('id',$id)->first();
        return $this->success(new CareerResource($career),'career show');
    }


    public function courses(){

        if (Cache::has('courses')) {
            $course = Cache::get('courses');
        }else{
            $course = Cache::rememberForever('courses', function () {
                return Course::with('image')->get();
            });
        }
        //If the frontend team want only the required fields ,use the GetLatestForCourseResource
        return $this->success(CourseResource::collection($course),'latest courses');
    }

    public function careers(){

        if (Cache::has('careers')) {
            $careers = Cache::get('careers');
        }else{
            $careers = Cache::rememberForever('careers', function () {
                return  Career::all();
            });
        }
       
        //If the frontend team want one the required fields ,use the GetLatestForCourseResource
        return $this->success(CareerResource::collection($careers),'careers');
    }
}
