<?php

namespace App\Http\Controllers\Client;

use App\Models\User;
use App\Models\Week;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\WeekCompletion;
use App\Models\CoursePerStudent;
use App\Models\LessonCompletion;
use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Models\CourseCompletion;
use Illuminate\Support\Facades\Validator;

class StudentController extends BaseController
{
    public function profile(Request $request)
    {
        $user = $request->user();
        $student = Student::where('user_id', $user->id)->with(['user' => function ($query) {
            $query->with(['image','roles']);
        }])->first();
        return response()->json($student);
    }

    public function update(Request $request, $student)
    {
        $student = Student::where('id', $student)->first();
        foreach ($request->all() as $key => $value) {
            $student->$key = $value;
        }
        $student->update();
        return $this->success($student, "student info updated");
    }
    public function enrollment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'course_id' => 'required',
            'student_id' => 'required'
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation failed",config('http_status_code.unprocessable_content'));
        }
        $enrollment =new Enrollment($request->all());
        $enrollment->save();
        return $this->success($enrollment,"successfully created",config('http_status_code.created'));
    }
    public function course_per_students($student)
    {
        return $this->success(CoursePerStudent::where('student_id',$student)->with(['batch' => function($query) {
            $query->with('course');
        },'student'])->get(),'All datas that student enroll');
    }
    public function lessonCompletion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "student_id" => "required",
            "lesson_id" => "required"
        ]);
        if($validator->fails()) {
            return $this->error($validator->errors(),"Validation Fail",config('http_status_code.unprocessable_content'));
        }
        $lesson = Lesson::where('id',$request->lesson_id)->first();
        $lessonCompletion = new LessonCompletion();
        $lessonCompletion->lesson_id = $lesson->id;
        $lessonCompletion->week_id = $lesson->week_id;
        $lessonCompletion->batch_id = $lesson->batch_id;
        $lessonCompletion->course_id = $lesson->course_id;
        $lessonCompletion->student_id = $request->student_id;
        $lessonCompletion->save();
        $this->weekCompletion($request,$lesson);
        return $this->success($lessonCompletion,"Successfully created",config('http_status_code.created'));
        }
    public function weekCompletion($request,$lesson)
    {
            $weekCompletion = WeekCompletion::where('student_id',$request->student_id)->where('course_id',$lesson->course_id)->where('batch_id',$lesson->batch_id)->where('week_id',$lesson->week_id)->first();
            $weekCompletion->lesson_completion_count++;
            $weekCompletion->update();
            if($weekCompletion->lesson_completion_count == $weekCompletion->lesson_count) {
                $this->courseCompletion($request,$lesson);
            }
    }
    public function courseCompletion($request,$lesson)
    {
        echo "hello";
        $courseCompletion = CourseCompletion::where('student_id',$request->student_id)->where('course_id',$lesson->course_id)->first();
        $courseCompletion->week_completion_count++;
        $courseCompletion->update();
    }
}
