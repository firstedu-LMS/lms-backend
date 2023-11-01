<?php

namespace App\Log;

trait LogModelService
{
    protected static function booted()
    {
        parent::booted();

        static::updating(function ($model) {
            $oldValues = $model->getOriginal(); 
            $newValues = $model->getAttributes(); 
            logger($oldValues);
            logger($newValues);
        });

    }
}
