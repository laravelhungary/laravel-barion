<?php

namespace LaravelHungary\Barion;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use LaravelHungary\Barion\Enums\BarionEndpoint;

class BarionServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * {@inheritdoc}
     */
    public function provides()
    {
        return [Barion::class];
    }

    /**
     * Bootstraps the application services.
     */
    public function boot()
    {
        $vendorConfigPath = __DIR__.'/../../../resources/config/laravel-barion.php';

        $this->mergeConfigFrom($vendorConfigPath, 'laravel-barion');

        $this->publishes([
            $vendorConfigPath => config_path('laravel-barion.php'),
        ]);
    }

    /**
     * Registers the application services.
     */
    public function register()
    {
        $this->app->bind(Barion::class, function () {
            return new Barion(
                new Client(),
                $this->getEndpoint(),
                config('laravel-barion.pos_key'),
                config('laravel-barion.associative')
            );
        });
    }

    /**
     * Gets the endpoint URL to use.
     *
     * @return string
     */
    protected function getEndpoint()
    {
        $useLive = config('laravel-barion.live_environment');

        if ($useLive) {
            return BarionEndpoint::LIVE;
        }

        return BarionEndpoint::TEST;
    }
}
