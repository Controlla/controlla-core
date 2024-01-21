<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;

class ReplaceLinesCommand extends Command
{
    use WithModelStub;

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'controlla:replace:lines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replacement lines';

    /**
     * Files to be changed.
     *
     * @var array
     */
    protected $replaceFiles = [
        'app/Http/Controllers/IndexController.php',
        'app/Providers/AppServiceProvider.php',
        'routes/api.php',
        'database/seeders/PermissionsTableSeeder.php',
    ];

    /**
     * Replace lines that can be used for generation.
     *
     * @var array
     */
    protected $replaceLines = [
        '// New MenuItem' => 'menuItem',
        '// New Singleton' => 'register',
        '// New ApiRoute' => 'apiRoute',
        '// New Permissions' => 'permissions',
    ];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return bool|null
     */
    public function handle()
    {
        $model = $this->getModelInput();

        $this->replacesLines($model);

        $this->info('Replaced lines successfully.');
    }

    public function replacesLines($model)
    {
        foreach (array_values($this->replaceLines) as $key => $stub) {
            $path = $this->getPath($this->replaceFiles[$key]);
            $file = $this->files->get($path);
            $tag = array_keys($this->replaceLines)[$key];
            $this->files->put($path, $this->buildClass($stub, $file, $tag));
        }
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name, $file, $tag)
    {
        $stub = $this->files->get($this->getStub($name));

        return $this->replaceClass($stub)->replaceFile($tag, $stub, $file);
    }

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @return $this
     */
    protected function replaceClass(&$stub)
    {
        $replace = [];

        $replace = $this->buildModelReplacements($replace);

        $stub = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );

        return $this;
    }

    /**
     * Replace the file for the given tag.
     *
     * @param  string  $tag
     * @param  string  $stub
     * @param  string  $file
     * @return string
     */
    protected function replaceFile($tag, $stub, $file)
    {
        return str_replace($tag, $stub, $file);
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        return $this->laravel['path'].'/../'.$name;
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(string $replaceLine)
    {
        return $this->resolveStubPath('/../lines/'.$replaceLine.'.stub');
    }

    /**
     * Get the desired model name from the input.
     *
     * @return string
     */
    protected function getModelInput()
    {
        return trim($this->option('model'));
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return $this->laravel->getNamespace();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'The name of the model'],
        ];
    }
}
