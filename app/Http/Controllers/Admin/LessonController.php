<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Resources\LessonResource;
use App\Models\Lesson;
use App\Models\Week;
use App\Http\Requests\LessonRequest;
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
        $lessons = Lesson::where('week_id', $week->id)->with(['video','week','course','batch'])->get();
        return $this->success(LessonResource::collection($lessons), 'all lessons');
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(LessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());
        WeekCompletion::where('week_id', $request->week_id)->increment('lesson_count');
        return $this->success(new LessonResource($lesson), 'Created', config('http_status_code.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson =  Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->error([], "lesson not found", config('http_status_code.not_found'));
        }
        return $this->success(new LessonResource($lesson), 'Details of lesson');
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
    public function update(LessonRequest $request, string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        if (!$lesson) {
            return $this->error([], "lesson not found", config('http_status_code.not_found'));
        }
        $lesson->update($request->validated());
        return $this->success(new LessonResource($lesson), 'lesson show');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::where('id', $id)->first();
        $lesson->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}
