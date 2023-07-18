<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
            'category_id',
            'name',
            'description',
            'fee',
            'status',
            'available'
    ];

    public function image(){
        return $this->morphOne(Image::class,'imageable');
    }
}
