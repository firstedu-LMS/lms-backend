<?php

namespace App\Http\Controllers\Admin;

use App\Models\Week;
use App\Models\Enrollment;
use App\Models\CourseCompletion;
use App\Models\CoursePerStudent;
use App\Http\Controllers\BaseController;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Lesson;
use App\Models\LessonCompletion;


class EnrollmentController extends BaseController
{
    public function index()
    {
        return $this->success(Enrollment::with(['course','student.user'])->get(),"All enrollments");
    }

    public function store(EnrollmentRequest $request)
    {
        $coursePerStudent = CoursePerStudent::create($request->validated());

        $weeks = Week::where('course_id', $request->course_id)
                        ->where('batch_id', $request->batch_id)
                        ->get();
        
        $courseCompletionData = $request->only(['student_id','course_id']);                
        $courseCompletionData['week_count'] = $weeks->count();

        $this->deleteOldEnrollment($request);

        CourseCompletion::create($courseCompletionData);
        
        $this->createlessonCompletionRelatedToWeeks($request,$weeks);

        return $this->success($coursePerStudent,"Successfully created");
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }

   

    public function createlessonCompletionRelatedToWeeks($request,$weeks){
        $lessonData = $request->only(['student_id','course_id','batch_id']);
        foreach($weeks as $week) {
            $lessonCount = Lesson::where('week_id',$week->id)->count();
            $lessonData['lesson_count'] = $lessonCount;
            $lessonData['week_id'] = $week->id;
            LessonCompletion::create($lessonData);
        }
    }

    public function  deleteOldEnrollment($request) {
        $enrollment = Enrollment::where('course_id',$request->course_id)->where('student_id',$request->student_id)->first();
        $enrollment->delete();
    }
    // public function destroy(Enrollment $enrollment)
    // {
    //     $enrollment->delete();
    //     return $this->success([], 'deleted', config('http_status_code.no_content'));
    // }
}
