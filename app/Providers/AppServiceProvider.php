<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        // Global constraints
        // We are implying that the id can only be numbers
        // Route::pattern('id', '[0-9]+');

        // We are implying that the id can only be letters
        // Route::pattern('id', '[a-zA-Z]+');
    }
}
