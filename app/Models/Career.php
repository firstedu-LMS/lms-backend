<?php

namespace App\Models;

use App\Events\CareerCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    protected $guarded=[];


    protected $dispatchesEvent =
    [
        'created' => CareerCreated::class
    ];

    

}
