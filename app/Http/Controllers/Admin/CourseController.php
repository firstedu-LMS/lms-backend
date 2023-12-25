<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Requests\CourseRequest;
use App\Http\Resources\CourseResource;
use App\Events\CourseDeleteResignCache;
use App\Http\Controllers\BaseController;
use App\Services\Client\CourseDeletionSerivce;
use App\Http\Controllers\Admin\ImageController;

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
        return $this->saveCourse($request);
    }
    public function saveCourse($request, $id = null)
    {
        $data = $request->validated();
        if ($id) {
            $course = Course::where('id', $id)->first();
            if (!$course) {
                return $this->error([], "course not found", config('http_status_code.not_found'));
            }
            $course->update($data);
            return $this->success(new CourseResource($course), config('http_status_code.ok'));
        } else {
            $imageController = new ImageController();
            $data["image_id"] = $imageController->handleImageStorage($data["image"],"course_image");
            $course = Course::create($data);
            return $this->success(new CourseResource($course), 'Created', config('http_status_code.created'));
        }
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
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, string $id)
    {
        return $this->saveCourse($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, CourseDeletionSerivce $courseDeletionService)
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
