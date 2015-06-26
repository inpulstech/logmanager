<?php

namespace Dick\LogManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\Router;

class LogManagerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(realpath(__DIR__.'/views'), 'logmanager');
        $this->setupRoutes($this->app->router);
        // this  for config

        // $this->publishes([
        //         __DIR__.'/config/logmanager.php' => config_path('logmanager.php'),
        // ]);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function setupRoutes(Router $router)
    {
        $router->group(['namespace' => 'Dick\LogManager\Http\Controllers'], function($router)
        {
            require __DIR__.'/Http/routes.php';
        });
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLogManager();
        // config([
        //         'config/logmanager.php',
        // ]);
    }

    private function registerLogManager()
    {
        $this->app->bind('logmanager',function($app){
            return new LogManager($app);
        });
    }
}