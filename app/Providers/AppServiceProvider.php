<?php

namespace jamx\Providers;

use Illuminate\Support\ServiceProvider;
use jamx\Extensions\SaasBlade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        SaasBlade::register();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
