<?php

namespace ahmetbarut\LaravelRouteDocs;

use Illuminate\Support\ServiceProvider;

class LaravelRouteDocsProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\ahmetbarut\LaravelRouteDocs\RouteDocsCommand::class, function($app){
            return new RouteDocsCommand($app['router']);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()){
            $this->commands([
                RouteDocsCommand::class
            ]);
        }
    }
}
