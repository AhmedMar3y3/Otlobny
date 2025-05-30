<?php

namespace App\Providers;

use App\Models\Review;
use App\Observers\StoreRatingObserver;
use Illuminate\Support\ServiceProvider;

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
        Review::observe(StoreRatingObserver::class);
    }
}
