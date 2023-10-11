<?php

namespace App\Models;

use App\Log\LogModelService;
use App\Events\CourseCreated;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory,LogModelService;

    protected $fillable = [
            'name',
            'description',
            'image_id',
            'age',
            'fee',
            'age',
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
