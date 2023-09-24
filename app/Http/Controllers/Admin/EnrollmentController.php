<?php

namespace App\Http\Controllers\Admin;

use App\Models\Week;
use App\Models\Batch;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\CourseCompletion;
use App\Models\CoursePerStudent;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Requests\EnrollmentRequest;
use App\Models\Lesson;
use App\Models\LessonCompletion;
use App\Models\WeekCompletion;
use CheckToDeleteService;
use Illuminate\Support\Facades\Validator;

class EnrollmentController extends BaseController
{
    public function index()
    {
        return $this->success(Enrollment::with(['course','student'])->get(),"All enrollments");
    }

    public function store(EnrollmentRequest $request)
    {
        $coursePerStudent = CoursePerStudent::create($request->validated());

        $weeks = Week::where('course_id', $request->course_id)
                        ->where('batch_id', $request->batch_id)
                        ->get();

        $this->deleteOldEnrollment($request);

        CourseCompletion::create([
            'week_count' => $this->countWeeks($request,$weeks),
            'student_id' => $request->student_id,
            'course_id '=>$request->course_id
        ]);
        
        $this->createlessonCompletionRelatedToWeeks($request,$weeks);

        return $this->success($coursePerStudent,"Successfully created");
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();
        return $this->success([], 'deleted', config('http_status_code.no_content'));
    }

    public function countWeeks($request,$weeks) {
        return $weekcount = $weeks->count();
    }

    public function createlessonCompletionRelatedToWeeks($request,$weeks){
        foreach($weeks as $week) {
            $lessonCount = Lesson::where('week_id',$week->id)->count();
            $lessonCompletion = new WeekCompletion();
            $lessonCompletion->lesson_count = $lessonCount;
            $lessonCompletion->student_id = $request->student_id;
            $lessonCompletion->course_id = $request->course_id;
            $lessonCompletion->batch_id = $request->batch_id;
            $lessonCompletion->week_id = $week->id;
            $lessonCompletion->save();
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
