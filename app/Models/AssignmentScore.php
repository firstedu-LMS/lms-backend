<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentScore extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id');
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class,'assignment_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}