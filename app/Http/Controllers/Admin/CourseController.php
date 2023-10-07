<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Events\CourseCreated;
use App\Models\CourseCompletion;
use App\Http\Requests\CourseRequest;
use App\Utils\CheckToDeleteService ;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use App\Http\Resources\CourseResource;
use App\Events\CourseDeleteResignCache;
use App\Services\CourseDeletionService;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseController;

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
        $data = $request->validated();
        $data['available'] = json_decode($request->available);
        $course = Course::create($data);
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
        $data = $request->validated();

        $data['available'] = json_decode($request->available);

        $course->update($data);
        
        return $this->success(new CourseResource($course), config('http_status_code.ok'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id,CourseDeletionService $courseDeletionService)
    {
        $course = Course::where('id', $id)->first();

        if (!$course) {
            return $this->error([], "course not found", config('http_status_code.not_found'));
        }
        
        try {
            //logic for deleting the course are implemented in the service
            $courseDeletionService->deleteCourse($course);
            event(new CourseDeleteResignCache());
            return $this->success([], 'deleted', config('http_status_code.no_content'));
        } catch (Exception $e) {
            return $this->error([], $e->getMessage(), config('http_status_code.unprocessable_content'));
        }

    }
}
