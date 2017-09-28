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
     * @var bool
     */
    protected $defer = true;

    /**
     *
     */
    public function boot()
    {
        $this->publishes([__DIR__ . '/../../config/OracleStorage.php' => config_path('oracle_storage.php')]);
    }

    /**
     *
     */
    public function register()
    {
        $this->app->singleton(OracleStorage::class, function() {
            return new OracleStorage(config('oracle_storage'));
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return [
            OracleStorage::class,
        ];
    }
}