<?php

namespace App\Listeners;

use App\Models\Career;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class CareerCacheListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        Cache::forget('careers');
        $careers = Career::all();
        Cache::forever('careers',$careers);
    }
}
