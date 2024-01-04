<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PrometheusServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton( CollectorRegistry::class, function () {

            Redis::setDefaultOptions(
                Arr::only( config( 'database.redis.default' ), [ 'host', 'password', 'username' ] )
            );

            return CollectorRegistry::getDefault();

        } );
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
