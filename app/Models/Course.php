<?php

namespace App\Models;

use App\Events\CourseCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = [
            'category_id',
            'name',
            'description',
            'image_id',
            'fee',
            'status',
            'available'
    ];

    protected $dispatchesEvent =
    [
        'created' => CourseCreated::class
    ];

    /**
     * Get the user that owns the Course
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}