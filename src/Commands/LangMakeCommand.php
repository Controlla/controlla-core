<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class LangMakeCommand extends GeneratorCommand
{
    use WithModelStub;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'component:lang';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new lang files';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Lang';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/lang.'.$this->option('lang').'.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\..\resources\lang\\'.$this->option('lang');
    }

    /**
     * Build the class with the given name.
     *
     * Remove the base controller import if we are already in base namespace.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $replace = [];

        $replace = $this->buildModelReplacements($replace);

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
            ['lang', 'l', InputOption::VALUE_OPTIONAL, 'indicate the language of the generated file.'],
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'Generate a resource lang for the given model.'],
        ];
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', Str::plural($name));

        return $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
    }
}
