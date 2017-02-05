<?php

namespace Service\Mosque;

use Illuminate\Support\ServiceProvider;

class DistanceServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Distance', function()
        {
            return new \Service\Mosque\Distance;
        });
    }
}
