<?php

namespace App\Providers;

use App\Services\Meteo\MeteoClient;
use Illuminate\Support\ServiceProvider;

class MeteoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
