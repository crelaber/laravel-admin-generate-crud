<?php

namespace App\Generate\Providers;

use Illuminate\Support\ServiceProvider;

class GenerateCrudServiceProvider extends ServiceProvider
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
        $this->app->singleton('GenerateCrudService', function($app){
            return new \App\Generate\helper\GenerateHelper();
        });
    }
}
