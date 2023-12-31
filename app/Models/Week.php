<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}