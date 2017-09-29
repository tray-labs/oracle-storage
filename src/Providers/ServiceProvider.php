<?php

namespace TrayLabs\OracleStorage\Providers;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use TrayLabs\OracleStorage\OracleStorage;

/**
 * Class ServiceProvider
 * @package TrayLabs\OracleStorage\Providers
 */
class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/OracleStorage.php' => config_path('oracle_storage.php')]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(OracleStorage::class, function() {
            return new OracleStorage(config('oracle_storage'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            OracleStorage::class,
        ];
    }
}