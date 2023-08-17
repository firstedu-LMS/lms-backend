<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory,SoftDeletes;
    protected $guarded =[];
    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
