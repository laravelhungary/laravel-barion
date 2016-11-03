<?php

namespace LaravelHungary\Barion;

use Illuminate\Support\ServiceProvider;

class BarionServiceProvider extends ServiceProvider
{
    protected $defer = true;

    /**
     * @inheritdoc
     */
    public function provides()
    {
        return [];
    }

    /**
     * Registers the application services.
     */
    public function register()
    {

    }
}
