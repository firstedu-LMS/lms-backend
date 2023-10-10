<?php

namespace App\Http\Controllers\Student;

use App\Models\User;
use App\Models\Week;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use App\Models\WeekCompletion;
use App\Models\CourseCompletion;
use App\Models\CoursePerStudent;
use App\Models\LessonCompletion;
use App\Http\Controllers\Controller;
use App\Http\Resources\WeekResource;
use App\Http\Controllers\BaseController;
use App\Http\Resources\LessonResource;
use Illuminate\Support\Facades\Validator;
use App\Utils\FormatJsonForResponseService\Student\ProfileJson;

class StudentController extends BaseController
{
    public function profile(Request $request)
    {
        $carentUser = $request->user();
        $user = User::where('id', $carentUser->id)->with(['roles', 'image'])->first();
        $student = Student::where('user_id', $user->id)->first();
        $courseCompletionCount = CourseCompletion::where('student_id', $student->id)->where('status', true)->count();
        $idProgressCourseCount = CourseCompletion::where('student_id', $student->id)->where('status', false)->count();
        $profile = new  ProfileJson($user, $student, $courseCompletionCount, $idProgressCourseCount);
        $data = $profile->getJson();
        return response()->json($data);
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

    // public function enrollment(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'course_id' => 'required',
    //         'student_id' => 'required'
    //     ]);
    //     if ($validator->fails()) {
    //         return $this->error($validator->errors(), "Validation failed", config('http_status_code.unprocessable_content'));
    //     }
    //     $enrollment = new Enrollment($request->all());
    //     $enrollment->save();
    //     return $this->success($enrollment, "successfully created", config('http_status_code.created'));
    // }

    public function lessonCompletion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "student_id" => "required",
            "lesson_id" => "required"
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Fail", config('http_status_code.unprocessable_content'));
        }
        $lesson = Lesson::where('id', $request->lesson_id)->first();
        $lessonCompletion = new LessonCompletion();
        $lessonCompletion->lesson_id = $lesson->id;
        $lessonCompletion->week_id = $lesson->week_id;
        $lessonCompletion->batch_id = $lesson->batch_id;
        $lessonCompletion->course_id = $lesson->course_id;
        $lessonCompletion->student_id = $request->student_id;
        $lessonCompletion->save();
        $this->weekCompletion($request, $lesson);
        return $this->success($lessonCompletion, "Successfully created", config('http_status_code.created'));
    }

    public function weekCompletion($request, $lesson)
    {
        $weekCompletion = WeekCompletion::where('student_id', $request->student_id)->where('course_id', $lesson->course_id)->where('batch_id', $lesson->batch_id)->where('week_id', $lesson->week_id)->first();
        $weekCompletion->lesson_completion_count++;
        if ($weekCompletion->lesson_completion_count == $weekCompletion->lesson_count) {
            $weekCompletion->status = true;
            $this->courseCompletion($request, $lesson);
        }
        $weekCompletion->update();
    }

    public function courseCompletion($request, $lesson)
    {
        $courseCompletion = CourseCompletion::where('student_id', $request->student_id)->where('course_id', $lesson->course_id)->first();
        $courseCompletion->week_completion_count++;
        if ($courseCompletion->week_completion_count == $courseCompletion->week_count) {
            $courseCompletion->status = true;
        }
        $courseCompletion->update();
    }
    public function course_per_students($student)
    {
        return $this->success(CoursePerStudent::where('student_id', $student)->with(['batch' => function ($query) {
            $query->with(['course' => function ($query) {
                $query->with('image');
            }]);
        }, 'student'])->get(), 'All data that the student has enrolled');
    }

    public function studentGetweeksOfCourse(Request $request)
    {
        $exist = CoursePerStudent::where('student_id', $request->student_id)->where('course_id', $request->course_id)->where('batch_id', $request->batch_id)->get();
        if ($exist) {
            $completion = CourseCompletion::where('student_id', $request->student_id)->where('course_id', $request->course_id)->first();
            $count = $completion->week_completion_count;
            $weeks = Week::where('course_id', $request->course_id)->where('batch_id', $request->batch_id)->get();
            for ($i = 0; $i <= $count; $i++) {
                $weeks[$i]['locked'] = true;
            }
            return $this->success(WeekResource::collection($weeks), 'all weeks');
        } else {
            return $this->error(["message" => "Course not found for student"], "", config('http_status_code.not_found'));
        }
    }
    public function studentGetlessonsOfWeek(Request $request)
    {
        $exist = CoursePerStudent::where('student_id', $request->student_id)->where('batch_id', $request->batch_id)->where('course_id', $request->course_id)->first();
        if ($exist) {
            $completion = WeekCompletion::where('student_id', $request->student_id)->where('course_id', $request->course_id)->where('week_id', $request->week_id)->first();
            $count = $completion->lesson_completion_count;
            $lessons = Lesson::where('course_id', $request->course_id)->where('batch_id', $request->batch_id)->where('week_id', $request->week_id)->get();
            for ($i = 0; $i <= $count; $i++) {
                $lessons[$i]['locked'] = true;
            }
            return $this->success(LessonResource::collection($lessons), 'all weeks');
        }
    }
}