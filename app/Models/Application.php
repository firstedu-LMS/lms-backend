<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function cv(){
         return $this->belongsTo(CvForm::class,'cv_id');
    }
}
