<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class ExportMakeCommand extends GeneratorCommand
{
    use WithModelStub;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:export';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new export class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Export';

    /**
     * Get the stub file for the generator.
     *
     * @return void|string
     */
    protected function getStub()
    {
        return $this->option('model')
            ? $this->resolveStubPath('/../stubs/export.stub')
            : $this->error('Something went wrong!');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Exports';
    }

    /**
     * Build the class with the given name.
     * Remove the base controller import if we are already in base namespace.
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
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate an export for the given model.'],
        ];
    }
}
