<?php

namespace App\Providers;

use App\Models\Career;
use Illuminate\Support\ServiceProvider;
use App\Observers\CareerObserver;
use App\Models\Course;
use App\Observers\CourseObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Career::observe(CareerObserver::class);
        Course::observe(CourseObserver::class);
    }
}
