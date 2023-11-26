<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Week;
use App\Http\Requests\LessonRequest;
use App\Http\Resources\InstructorLessonResource;
use App\Models\WeekCompletion;
use Illuminate\Http\Request;

class LessonController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($week_id)
    {
        $week = Week::where('id', $week_id)->first();
        $lessons = Lesson::where('week_id', $week->id)->get();
        return $this->success(LessonResource::collection($lessons), 'all lessons');
    }


    public function getInstructorLesson($week_id){
        $week = Week::where('id', $week_id)->first();
        $lessons = Lesson::where('week_id', $week->id)->get();
        return $this->success(InstructorLessonResource::collection($lessons), 'all lessons');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        return $this->saveLesson($request);
    }

    public function saveLesson($request,$id = null)
    {
        $data = $request->validated();
        if($id) {
            $lesson = Lesson::where('id', $id)->first();
            if (!$lesson) {
                return $this->error([], "lesson not found", config('http_status_code.not_found'));
            }
            $lesson->update($data);
            return $this->success(new LessonResource($lesson), 'lesson show');
        }else {
            $lesson = Lesson::create($data);
            WeekCompletion::where('week_id', $request->week_id)->increment('lesson_count');
            return $this->success(new LessonResource($lesson), 'Created', config('http_status_code.created'));
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson =  Lesson::where('id', $id)->with(['week','course','video','batch'])->first();
        if (!$lesson) {
            return $this->error([], "lesson not found", config('http_status_code.not_found'));
        }
        return $this->success(new LessonResource($lesson), 'Details of lesson');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LessonRequest $request, string $id)
    {
        return $this->saveLesson($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        WeekCompletion::where('week_id', $lesson->week_id)->decrement('lesson_count');
        $lesson->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
