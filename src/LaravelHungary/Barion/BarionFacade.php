<?php

namespace LaravelHungary\Barion;

use Illuminate\Support\Facades\Facade;

class BarionFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return Barion::class;
    }
}
