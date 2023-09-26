<?php

namespace App\Utils\FormatJsonForResponseService\Student;
use App\Utils\FormatJsonForResponseService\JsonResponseInterface;

class ProfileJson  implements  JsonResponseInterface {
    protected  $user;
    protected  $student;
    protected  $courseCompletionCount;
    protected  $idProgressCourseCount;

    public function __construct($user,$student,$courseCompletionCount,$idProgressCourseCount){
        $this->user =  $user;
        $this->student =  $student;
        $this->courseCompletionCount =  $courseCompletionCount;
        $this->idProgressCourseCount =  $idProgressCourseCount;
    }

    public function format(){
      return  [
                'id' => $this->student->id,
                'name' => $this->user->name,
                'student_id'=> $this->student->student_id,
                'email' => $this->user->email,
                'phone' =>$this->student->phone,
                'address' => $this->student->address,
                'education' => $this->student->education,
                'date_of_birth' => $this->student->date_of_birth,
                'created_at' => $this->student->created_at->format('d-m-Y'),
                'course_completion_count' => $this->courseCompletionCount,
                'id_progess_course_count' => $this->idProgressCourseCount,
                'achievement_count' => 1,
                'roles' => $this->user->roles,
                'image' => $this->user->image ? $this->user->image->image : [],
                'image_id' => $this->user->image ? $this->user->image->id : ''
            ];
    }

    public function getJson() {
        return $this->format();
    }
}
