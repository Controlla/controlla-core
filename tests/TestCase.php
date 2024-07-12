<?php

namespace Controlla\Core\Tests;

use Controlla\Core\Contracts\Controlla;
use Controlla\Core\CoreServiceProvider;
use Orchestra\Testbench\Concerns\InteractsWithPublishedFiles;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    use InteractsWithPublishedFiles;

    /** @var Controlla This was added only to help IDE auto-completion */
    protected $controlla;

    protected function setUp(): void
    {
        parent::setUp();

        $this->controlla = $this->app->make('controlla');
        // Factory::guessFactoryNamesUsing(
        //     fn (string $modelName) => 'Controlla\\Core\\Database\\Factories\\'.class_basename($modelName).'Factory'
        // );
    }

    protected function getPackageProviders($app)
    {
        return [
            CoreServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_core_table.php.stub';
        $migration->up();
        */
    }
}
