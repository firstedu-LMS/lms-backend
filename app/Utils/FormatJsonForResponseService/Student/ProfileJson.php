<?php

namespace App\Utils\FormatJsonForResponseService\Student;

use App\Utils\FormatJsonForResponseService\JsonResponseInterface;

class ProfileJson  implements JsonResponseInterface
{
    protected  $user;
    protected  $student;
    protected  $courseCompletionCount;
    protected  $inProgressCourseCount;

    public function __construct($user, $student, $courseCompletionCount, $inProgressCourseCount)
    {
        $this->user =  $user;
        $this->student =  $student;
        $this->courseCompletionCount =  $courseCompletionCount;
        $this->inProgressCourseCount =  $inProgressCourseCount;
    }

    public function format()
    {
        return  [
            'id' => $this->student->id,
            'name' => $this->user->name,
            'slug' => $this->student->slug,
            'student_id' => $this->student->student_id,
            'email' => $this->user->email,
            'phone' => $this->student->phone,
            'address' => $this->student->address,
            'education' => $this->student->education,
            'date_of_birth' => $this->student->date_of_birth,
            'created_at' => $this->student->created_at->format('d-m-Y'),
            'course_completion_count' => $this->courseCompletionCount,
            'in_progess_course_count' => $this->inProgressCourseCount,
            'achievement_count' => 1,
            'roles' => $this->user->roles,
            'image' => $this->user->image ? $this->user->image->image : [],
            'image_id' => $this->user->image ? $this->user->image->id : ''
        ];
    }

    public function getJson()
    {
        return $this->format();
    }
}
