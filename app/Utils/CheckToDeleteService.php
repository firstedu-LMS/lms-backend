<?php

namespace App\Utils;

use App\Http\Controllers\Admin\CourseController;
use App\Models\Batch;
use App\Models\CourseCompletion;
use App\Models\Student;


class CheckToDeleteService {
    protected $model;
    protected $clean;
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
        $this->clean = true;
    }

    // public function doesBatchHasRelatedAssignedInstructor(){
    //     $isCourseHasAttendedStudent = Batch::where('course_id',$this->id)->count();
    //     if ($isCourseHasAttendedStudent) {
    //        $this->clean = false;
    //     }
    //     return $this;
    // }

    // public function doesWeekHasRelatedLesson(){
    //     $isCourseHasAttendedStudent = CourseCompletion::where('course_id',$this->id)->count();
    //     if ($isCourseHasAttendedStudent) {
    //        $this->clean = false;
    //     }
    //     return $this;
    // }

    public function doesCourseHasRelatedStudentAndInstructor() {
        $isCourseHasAttendedStudent = CourseCompletion::where('course_id',$this->id)->count();
        $isInstructorInThisBatchTeachingThisCourse = Batch::where('course_id',$this->id)->count();
        if ($isCourseHasAttendedStudent || $isInstructorInThisBatchTeachingThisCourse) {
           $this->clean = false;
        }
        return $this;
    }


    public function isClean() {
        return $this->clean;
    }

}