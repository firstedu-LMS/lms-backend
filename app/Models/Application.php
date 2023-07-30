<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];
    use HasFactory;

    public function cv_form(){
         return $this->belongsTo(CvForm::class);
    }
}
