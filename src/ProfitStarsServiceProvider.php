<?php

namespace jdavidbakr\ProfitStars;

use Illuminate\Support\ServiceProvider;

class ProfitStarsServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'profitstars');

        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/profit-stars.php' => config_path('profit-stars.php')
            ], 'config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
