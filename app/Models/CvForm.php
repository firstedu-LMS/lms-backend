<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvForm extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function file()
    {
        return $this->belongsTo(File::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function applications()
    {
        return $this->hasMany(Application::class,'cv_id');
    }
}
