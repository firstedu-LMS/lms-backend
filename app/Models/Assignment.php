<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $guarded = [];
    
    public function file()
    {
        return $this->belongsTo(File::class);
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class);
    }
    use HasFactory;
}
