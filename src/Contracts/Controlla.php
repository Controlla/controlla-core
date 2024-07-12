<?php

/**
 * Contains the Controlla interface.
 *
 * @copyright   Copyright (c) 2024 Controlla
 * @author      Controlla
 * @license     MIT
 *
 * @since       2016-10-30
 */

namespace Controlla\Core\Contracts;

use Illuminate\Support\Collection;

interface Controlla
{
    /**
     * Registers a new module based on its class name
     *
     * @param  string  $moduleClass
     * @param  array  $config
     */
    public function registerModule($moduleClass, $config = []);

    /**
     * Returns the collection of available modules
     *
     * @param  bool  $includeImplicits
     */
    public function getModules($includeImplicits = false): Collection;

    /**
     * Returns the root folder on the filesystem containing the module
     */
    public function getBasePath(): string;
}
