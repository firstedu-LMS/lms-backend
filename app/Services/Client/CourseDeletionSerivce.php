<?php

namespace App\Services\Client;

use Exception;
use App\Models\Batch;
use App\Models\CourseCompletion;

class CourseDeletionSerivce
{
    public function deleteCourse($course)
    {
        $isCourseHasAttendedStudent = CourseCompletion::where('course_id', $course->id)->count();
        $isInstructorInThisBatchTeachingThisCourse = Batch::where('course_id', $course->id)->count();
        if ($isCourseHasAttendedStudent > 0 || $isInstructorInThisBatchTeachingThisCourse > 0) {
            throw new Exception("There are students who are attending this course");
        } else {
            $course->delete();
        }
    }
}