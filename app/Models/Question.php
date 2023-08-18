<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
    protected $guarded =[];
    use HasFactory;
}
