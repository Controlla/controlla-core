<?php

namespace Controlla\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Controlla\Core\Controlla
 */
class Controlla extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Controlla\Core\Controlla::class;
    }
}
