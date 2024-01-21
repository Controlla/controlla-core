<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class NewComponentCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'controlla:make:crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new component from model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void|bool
     */
    public function handle()
    {
        if (parent::handle() === false) {
            return false;
        }

        $this->createFactory();

        $this->createMigration();

        $this->createSeeder();

        $this->createRequest('create');

        $this->createRequest('update');

        $this->createExport();

        $this->createImport();

        $this->createResource();

        $this->createPolicy();

        $this->createTest();

        $this->createController();

        $this->createInterfaceRepository();

        $this->createRepository();

        $this->createInterfaceService();

        $this->createService();

        $this->createLang();

        $this->replaceLines();
    }

    /**
     * Create a model factory for the model.
     *
     * @return void
     */
    protected function createFactory()
    {
        $factory = Str::studly(class_basename($this->argument('name')));

        $this->call('make:factory', [
            'name' => "{$factory}Factory",
            '--model' => $this->qualifyClass($this->getNameInput()),
        ]);
    }

    /**
     * Create a migration file for the model.
     *
     * @return void
     */
    protected function createMigration()
    {
        $table = Str::plural(Str::snake(class_basename($this->argument('name'))));

        $this->call('make:migration', [
            'name' => "create_{$table}_table",
            '--create' => $table,
        ]);
    }

    /**
     * Create a seeder file for the model.
     *
     * @return void
     */
    protected function createSeeder()
    {
        $seeder = Str::studly(class_basename($this->argument('name')));

        $this->call('make:seed', [
            'name' => "{$seeder}Seeder",
        ]);
    }

    /**
     * Create a request file for the model.
     *
     * @return void
     */
    protected function createRequest($type)
    {
        $request = Str::studly(class_basename($this->argument('name')));

        $method = $type === 'create' ? 'Store' : 'Update';

        $this->call('controlla:make:request', [
            'name' => "{$request}{$method}Request",
            '--model' => $request,
            '--type' => $type,
        ]);
    }

    /**
     * Create a export file for the model.
     *
     * @return void
     */
    protected function createExport()
    {
        $export = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('controlla:make:export', [
            'name' => "{$export}Export",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a import file for the model.
     *
     * @return void
     */
    protected function createImport()
    {
        $import = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('controlla:make:import', [
            'name' => "{$import}Import",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a resource file for the model.
     *
     * @return void
     */
    protected function createResource()
    {
        $resource = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:make:resource', [
            'name' => "{$resource}Resource",
            '--model' => $resource,
        ]);
    }

    /**
     * Create a policy file for the model.
     *
     * @return void
     */
    protected function createPolicy()
    {
        $policy = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('controlla:make:policy', [
            'name' => "{$policy}Policy",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a controller for the model.
     *
     * @return void
     */
    protected function createController()
    {
        $controller = Str::studly(class_basename($this->argument('name')));

        $modelName = $this->qualifyClass($this->getNameInput());

        $this->call('controlla:make:controller', [
            'name' => "{$controller}Controller",
            '--model' => $modelName,
        ]);
    }

    /**
     * Create a repository interface for the model.
     *
     * @return void
     */
    protected function createInterfaceRepository()
    {
        $repository = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:make:repositoryinterface', [
            'name' => "{$repository}RepositoryInterface",
            '--model' => $repository,
        ]);
    }

    /**
     * Create a repository for the model.
     *
     * @return void
     */
    protected function createRepository()
    {
        $repository = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:make:repository', [
            'name' => "{$repository}Repository",
            '--model' => $repository,
        ]);
    }

    /**
     * Create a service interface for the model.
     *
     * @return void
     */
    protected function createInterfaceService()
    {
        $service = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:make:serviceinterface', [
            'name' => "{$service}ServiceInterface",
            '--model' => $service,
        ]);
    }

    /**
     * Create a service for the model.
     *
     * @return void
     */
    protected function createService()
    {
        $service = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:make:service', [
            'name' => "{$service}Service",
            '--model' => $service,
        ]);
    }

    /**
     * Create a test file for the model.
     *
     * @return void
     */
    protected function createTest()
    {
        $test = Str::studly(class_basename($this->argument('name')));

        $this->call('make:test', [
            'name' => "{$test}ControllerTest",
        ]);
    }

    /**
     * Create a lang file for the model.
     *
     * @return void
     */
    protected function createLang()
    {
        $model = Str::studly(class_basename($this->argument('name')));
        $file = Str::snake(class_basename($this->argument('name')));

        $this->call('controlla:make:lang', [
            'name' => "{$file}",
            '--model' => $model,
            '--lang' => 'es',
        ]);

        $this->call('controlla:make:lang', [
            'name' => "{$file}",
            '--model' => $model,
            '--lang' => 'en',
        ]);
    }

    /**
     * Replace lines of files.
     *
     * @return void
     */
    protected function replaceLines()
    {
        $module = Str::studly(class_basename($this->argument('name')));

        $this->call('controlla:replace:lines', [
            '--model' => $module,
        ]);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/model.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Models';
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }
}
