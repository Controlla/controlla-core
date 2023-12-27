<?php

namespace Controlla\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Controlla\Core\Core
 */
class Core extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Controlla\Core\Core::class;
    }
}
