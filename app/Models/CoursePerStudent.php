<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoursePerStudent extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function batch()
    {
        return $this->belongsTo(Batch::class,'course_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
