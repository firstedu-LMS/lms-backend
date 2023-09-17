<?php

use App\Http\Controllers\Admin\CourseController;
use App\Models\Batch;
use App\Models\Student;


class CheckToDeleteService {
    protected $model;
    protected $clean;
    protected $id;
    public function __construct($model,$id)
    {
        $this->model = $model;
        $this->id = $id;
        $this->clean = true;
    }

    public function doesCourseHasRelatedStudent() {
        // $student  = Student::where('course_id',$this->id)->first();
        return $this;
    }

    public function isClean() {
        return $this;
    }

    public function build () {
        return new CourseController();
    }

}