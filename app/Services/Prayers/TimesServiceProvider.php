<?php

namespace Service\Prayers;

use Illuminate\Support\ServiceProvider;

class TimesServiceProvider extends ServiceProvider
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
        $this->app->bind('Times', function()
        {
            return new \Service\Prayers\Times;
        });
    }
}
