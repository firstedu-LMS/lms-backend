<?php

namespace App\Http\Controllers\Admin;

use App\Models\Batch;
use App\Models\Week;
use Illuminate\Http\Request;
use App\Http\Requests\WeekRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeekResource;
use App\Http\Controllers\BaseController;
use App\Models\CourseCompletion;

class WeekController extends BaseController
{
    public function index($batch_id)
    {
        $batch = Batch::where('id', $batch_id)->first();
        $weeks = Week::where('batch_id', $batch->id)->with(['course', 'batch'])->get();
        return $this->success(WeekResource::collection($weeks), 'all weeks');
    }

    public function createWeekNumber($batch_id)
    {
        $week = Week::where('batch_id', $batch_id)->select('week_number')
            ->orderByDesc('week_number')
            ->value('week_number');
        $weekId = substr($week, 5);
        if ($weekId) {
            $weekName = $weekId + 1;
        } else {
            $weekName = config('week.week_number');
        }
        return 'week-' . $weekName;
    }


public function store(WeekRequest $request)
{
    $validatedData = $request->validated();
    $weekNumber = $this->createWeekNumber($request->batch_id);
    $validatedData['week_number'] = $weekNumber;
    $week = Week::create($validatedData);
    
    CourseCompletion::where('course_id', $request->course_id)->increment('week_count');
    
    $weekResource = new WeekResource($week);
    return $this->success($weekResource, 'Created', config('http_status_code.created'));
}

    public function show($id)
    {
        $week = Week::where('id', $id)->first();
        if (!$week) {
            return $this->error([], 'there is no week', config('http_status_code.not_found'));
        }
        return $this->success(new WeekResource($week), 'Week show for this id');
    }

    public function destroy(Week $week)
    {
        $week->delete();
        
        $courseCompletion = CourseCompletion::where('course_id',$week->course_id)->first();
        if ($courseCompletion->week_count != 0) {
            $courseCompletion->week_count--;
            $courseCompletion->update();
        }
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }
}