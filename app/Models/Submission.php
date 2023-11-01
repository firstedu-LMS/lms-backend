<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }
    public function submission_file()
    {
        return $this->belongsTo(File::class, 'submission_file_id');
    }
}