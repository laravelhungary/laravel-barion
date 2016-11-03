<?php
/**
 * (c) 2016. 11. 03..
 * Authors: nxu
 */

namespace LaravelHungary\Barion;

use Illuminate\Support\Facades\Facade;

class BarionFacade extends Facade
{
    public static function getFacadeAccessor()
    {
        return Barion::class;
    }
}
