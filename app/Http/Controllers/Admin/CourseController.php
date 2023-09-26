<?php

namespace App\Http\Controllers\Admin;

use App\Events\CourseCreated;
use App\Events\CourseDeleteResignCache;
use App\Http\Controllers\BaseController;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseCompletion;
use App\Models\Student;
use App\Utils\CheckToDeleteService as UtilsCheckToDeleteService;
use CheckToDeleteService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;

class CourseController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->success(CourseResource::collection(Course::with('image')->get()), 'All courses');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        // $data = $request->validated();
        // $data['available'] = json_decode($request->available);
        // $course = Course::create($data);
        $course = new Course();
        $course->name = $request->name;
        $course->description = $request->description;
        $course->fee = $request->fee;
        $course->age = $request->age;
        $course->status = $request->status;
        $course->available = $request->available;
        $course->image_id = $request->image_id;
        $course->save();
        return $course;
        return $this->success(new CourseResource($course), 'Created', config('http_status_code.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $course = Course::where('id', $id)->first();
        if (!$course) {
            return $this->error([], "course not found", config('http_status_code.not_found'));
        }
        return $this->success(new CourseResource($course), 'Details of course');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        $course = Course::where('id', $id)->first();
        if (!$course) {
            return $this->error([], "course not found", config('http_status_code.not_found'));
        }
        $course->name =  $request->name;
        $course->description =  $request->description ;
        $course->fee =  $request->fee;
        $course->age = $request->age;
        $course->status =   $request->status ;
        $course->image_id = $request->image_id;
        $course->available = json_decode($request->available);
        $course->update();
        return $this->success(new CourseResource($course), config('http_status_code.ok'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::where('id', $id)->first();

        if (!$course) {
            return $this->error([], "course not found", config('http_status_code.not_found'));
        }

        $service = new UtilsCheckToDeleteService($id);
        $isClean = $service->doesCourseHasRelatedStudentAndInstructor()->isClean();
        if ($isClean) {
            return $this->error([],'There are students who are attending this course',config('http_status_code.unprocessable_content'));
        }
        $course->delete();
        event(new CourseDeleteResignCache());

        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
