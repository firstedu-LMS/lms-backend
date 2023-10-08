<?php

namespace App\Log;

trait LogModelService
{
    protected static function booted()
    {
        parent::booted();

        static::updated(function ($model) {
            
        });

    }
}
