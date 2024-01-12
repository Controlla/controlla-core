<?php

namespace Controlla\Core\Tests\Integration\Generators;

use Controlla\Core\CoreServiceProvider;
use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    use InteractsWithPublishedFiles;

    protected function getPackageProviders($app)
    {
        return [
            CoreServiceProvider::class,
        ];
    }
}
