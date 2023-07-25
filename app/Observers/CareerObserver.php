<?php

namespace App\Observers;

use App\Events\CareerCreated;
use App\Models\Career;

class CareerObserver
{
    /**
     * Handle the Career "created" event.
     */
    public function created(Career $career): void
    {
        event(new CareerCreated());
    }

    /**
     * Handle the Career "updated" event.
     */
    public function updated(Career $career): void
    {
        //
    }

    /**
     * Handle the Career "deleted" event.
     */
    public function deleted(Career $career): void
    {
        //
    }

    /**
     * Handle the Career "restored" event.
     */
    public function restored(Career $career): void
    {
        //
    }

    /**
     * Handle the Career "force deleted" event.
     */
    public function forceDeleted(Career $career): void
    {
        //
    }
}
