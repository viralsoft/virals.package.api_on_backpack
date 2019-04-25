<?php

namespace ViralsBackpack\BackPackAPI;

use ViralsBackpack\BackPackAPI\Console\Commands\CrudBackpackCommand;
use Illuminate\Support\ServiceProvider;
use ViralsBackpack\BackPackAPI\Console\Commands\AddCustomRouteContent;
use ViralsBackpack\BackPackAPI\Console\Commands\CrudAPIControllerBackpackCommand;

class BackPackAPIServiceProvider extends ServiceProvider
{
    /**
     * Where custom routes can be written, and will be registered by Backpack.
     *
     * @var string
     */
    public $customRoutesFilePath = '/routes/backpack/api.php';

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // if the custom routes file is published, register its routes
        if (file_exists(base_path().$this->customRoutesFilePath)) {
            $this->loadRoutesFrom(base_path().$this->customRoutesFilePath);
        }
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../config/backpackapi.php', 'backpackapi');

        // Register the service the package provides.
        $this->app->singleton('BackPackAPI', function ($app) {
            return new BackPackAPI;
        });
    }



    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['backpackapi'];
    }

    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/backpackapi.php' => config_path('backpackapi.php'),
        ], 'backpackapi.config');

        // Registering package commands.
        if ($this->app->runningInConsole()) {
            $this->commands([
                CrudAPIControllerBackpackCommand::class,
                AddCustomRouteContent::class,
                CrudBackpackCommand::class
            ]);
        }

        // Publish route
        $backpack_custom_routes_file = [__DIR__.$this->customRoutesFilePath => base_path($this->customRoutesFilePath)];
        $this->publishes($backpack_custom_routes_file, 'custom_routes');
    }
}
