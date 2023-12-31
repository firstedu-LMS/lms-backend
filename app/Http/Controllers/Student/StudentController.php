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
use App\Http\Requests\LessonCompletionRequest;
use App\Http\Resources\LessonResource;
use App\Http\Resources\StudentLessonsWeekResource;
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
        $inProgressCourseCount = CourseCompletion::where('student_id', $student->id)->where('status', false)->count();
        $profile = new  ProfileJson($user, $student, $courseCompletionCount, $inProgressCourseCount);
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



    public function weekCompletion($request, $lesson)
    {
        $weekCompletion = WeekCompletion::where('student_id', $request->student_id)->where('course_id', $lesson->course_id)->where('batch_id', $lesson->batch_id)->where('week_id', $lesson->week_id)->first();
        if ($weekCompletion->week_count > $weekCompletion->lesson_completion_count) {
            $weekCompletion->lesson_completion_count++;
        }
        if ($weekCompletion->lesson_completion_count == $weekCompletion->lesson_count) {
            $weekCompletion->status = true;
            $this->courseCompletion($request, $lesson);
        }
        $weekCompletion->update();
    }

    public function lessonCompletion(LessonCompletionRequest $request)
    {
        $lesson = Lesson::where('id', $request->lesson_id)->first();
        $lessonCompletion = LessonCompletion::create([
            'lesson_id'      =>  $lesson->id,
            'week_id'        =>  $lesson->week_id,
            'batch_id'       =>  $lesson->batch_id,
            'course_id'      =>  $lesson->course_id,
            'student_id'     =>  $request->student_id
        ]);
        $this->weekCompletion($request, $lesson);
        return $this->success($lessonCompletion, "Successfully created", config('http_status_code.created'));
    }

    public function studentGetweeksOfCourse($student_id, $course_id, $batch_id)
    {
        $exist = CoursePerStudent::where('student_id', $student_id)->where('course_id', $course_id)->where('batch_id', $batch_id)->get();
        if ($exist) {
            $completion = CourseCompletion::where('student_id', $student_id)->where('course_id', $course_id)->first();
            $count = $completion->week_completion_count;
            $weeks = Week::where('course_id', $course_id)->where('batch_id', $batch_id)->get();
            for ($i = 0; $i <= $count; $i++) {
                $weeks[$i]['locked'] = true;
            }
            return $this->success(WeekResource::collection($weeks), 'all weeks');
        } else {
            return $this->error(["message" => "Course not found for student"], "", config('http_status_code.not_found'));
        }
    }

    public function coursePerStudents($student)
    {
        $coursePerStudents = CoursePerStudent::where('student_id', $student)->with(['batch', 'course.image', 'student'])->get();
        $data = $coursePerStudents->map(function ($coursePerStudents) {
            $courseCompletion = CourseCompletion::where('student_id', $coursePerStudents->student_id)->where('course_id', $coursePerStudents->course_id)->first();
            $percentage = ($courseCompletion->week_completion_count / $courseCompletion->week_count) * 100;
            return  [
                "id"  => $coursePerStudents->course_id,
                "name"  => $coursePerStudents->course->name,
                "course_image" => $coursePerStudents->course->image?->image,
                "batch_name" => $coursePerStudents->batch->name,
                "batch_id"  => $coursePerStudents->batch_id,
                "percentage" => (int) substr((int)$percentage, 0, 3)
            ];
        });
        return $this->success($data, 'All data that the student has enrolled');
    }

    public function studentGetlessonsOfWeek($student_id, $course_id, $batch_id, $week_id)
    {
        $exist = CoursePerStudent::where('student_id', $student_id)->where('batch_id', $batch_id)->where('course_id', $course_id)->first();
        if ($exist) {
            $completion = WeekCompletion::where('student_id', $student_id)->where('course_id', $course_id)->where('week_id', $week_id)->first();
            $count = $completion->lesson_completion_count;
            $lessons = Lesson::where('course_id', $course_id)->where('batch_id', $batch_id)->where('week_id', $week_id)->get();
            if ($count && $count !== 0) {
                // Adjust the loop count to handle cases where the user has completed some lessons.
                // For instance, if the user completed one lesson (count = 1), subtracting 1 from the loop count prevents errors.
                // Example: If lesson count = 3 and lesson completion count = 3, without adjustment, the loop would run three times,
                // potentially causing issues. Adjusting the count to 2 ensures only the correct number of lessons are processed.
                $loopCount = ($completion->lesson_count == $completion->lesson_completion_count) ? $count - 1  : $count ;
                for ($i = 0; $i <= $loopCount; $i++) {
                    $lessons[$i]['locked'] = true;
                }
            } else {
                $lessons[0]['locked'] = true;
            }

            return $this->success(LessonResource::collection($lessons), 'all weeks');
        }
    }
}
