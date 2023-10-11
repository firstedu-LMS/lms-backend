<?php

namespace App\Log;

trait LogModelService
{
    protected static function booted()
    {
        parent::booted();

        static::updating(function ($model) {
            $oldValues = $model->getOriginal(); // Old values
            $newValues = $model->getAttributes(); // New values
            logger($oldValues);
            logger($newValues);
        });

    }
}
