<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class RepositoryInterfaceMakeCommand extends GeneratorCommand
{
    use WithModelStub;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'controlla:make:repositoryinterface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository interface class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'RepositoryInterface';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/repository.interface.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories\\'.$this->option('model');
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [];
        if ($this->option('model')) {
            $replace = $this->buildModelReplacements($replace);
        }

        return str_replace(
            array_keys($replace), array_values($replace), parent::buildClass($name)
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate an policy for the given model.'],
        ];
    }
}
