<?php

namespace Controlla\Core\Modules;

use Carbon\Carbon;
use Controlla\Core\Contracts\Controlla as ControllaContract;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class BaseModuleServiceProvider extends ServiceProvider
{
    /** @var string */
    protected $basePath;

    /** @var string */
    protected $id;

    /** @var string */
    protected $name;

    /** @var string */
    protected $version;

    /** @var string */
    protected $namespaceRoot;

    /** @var ControllaContract */
    protected $controlla;

    /** @var array */
    protected $migrations = [];

    /** @var array */
    protected $models = [];

    /** @var array */
    protected $policies = [];

    /** @var array */
    protected $controllers = [];

    /** @var array */
    protected $requests = [];

    /** @var array */
    protected $resources = [];

    /** @var array */
    protected $repositories = [];

    /** @var array */
    protected $services = [];

    /**
     * BaseModuleServiceProvider class constructor
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->controlla = $app->make(ControllaContract::class); // retrieve the controlla singleton
        $this->basePath = dirname(dirname((new ReflectionClass(static::class))->getFileName()));
        $this->name = Str::title("{$this->id} Module");
        $this->namespaceRoot = "App\Modules\\".Str::title($this->id);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->publishes([
            __DIR__."/config/{$this->id}.php" => config_path("{$this->id}.php"),
        ], 'config');

        if ($this->areMigrationsEnabled()) {
            $this->registerMigrations();
        }

        if ($this->areModelsEnabled()) {
            $this->registerModels();
            $this->registerPolicies();
        }

        if ($this->areControllersEnabled()) {
            $this->registerControllers();
            $this->registerRequests();
            $this->registerResources();
            $this->registerRepositories();
            $this->registerServices();
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritDoc}
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * {@inheritDoc}
     */
    public function getNamespaceRoot(): string
    {
        return $this->namespaceRoot;
    }

    /**
     * Returns the root folder on the filesystem containing the module
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public function areMigrationsEnabled(): bool
    {
        return (bool) $this->config('migrations', true);
    }

    public function areModelsEnabled(): bool
    {
        return (bool) $this->config('models', true);
    }

    public function areControllersEnabled(): bool
    {
        return (bool) $this->config('controllers', true);
    }

    /**
     * Register the module's migrations
     */
    protected function registerMigrations()
    {
        $now = Carbon::now();
        foreach ($this->migrations as $migration) {
            $filePath = $this->getBasePath()."/resources/database/migrations/{$migration}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => $this->generateMigrationName(
                    $migration,
                    $now->addSecond()
                ),
            ], "{$this->id}-migrations");

            $this->loadMigrationsFrom($filePath);
        }
    }

    /**
     * Register models in a module
     */
    protected function registerModels()
    {
        foreach ($this->models as $key => $model) {
            $filePath = $this->getBasePath()."/Models/{$model}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Models/{$model}.php",
            ], "{$this->id}-models");
        }
    }

    /**
     * Register policies in a module
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $key => $policy) {
            $filePath = $this->getBasePath()."/Policies/{$policy}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Policies/{$policy}.php",
            ], "{$this->id}-policies");
        }
    }

    /**
     * Register controllers in a module
     */
    protected function registerControllers()
    {
        foreach ($this->controllers as $key => $controller) {
            $filePath = $this->getBasePath()."/Http/Controllers/{$controller}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Http/Controllers/Resources/{$controller}.php",
            ], "{$this->id}-controllers");
        }
    }

    /**
     * Register requests in a module
     */
    protected function registerRequests()
    {
        foreach ($this->requests as $key => $request) {
            $filePath = $this->getBasePath()."/Http/Requests/{$request}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Http/Requests/{$request}.php",
            ], "{$this->id}-requests");
        }
    }

    /**
     * Register resources in a module
     */
    protected function registerResources()
    {
        foreach ($this->resources as $key => $resource) {
            $filePath = $this->getBasePath()."/Http/Resources/{$resource}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Http/Resources/{$resource}.php",
            ], "{$this->id}-resources");
        }
    }

    /**
     * Register repositories in a module
     */
    protected function registerRepositories()
    {
        foreach ($this->repositories as $key => $repository) {
            $filePath = $this->getBasePath()."/Repositories/{$repository}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Repositories/{$repository}.php",
            ], "{$this->id}-repositories");
        }
    }

    /**
     * Register services in a module
     */
    protected function registerServices()
    {
        foreach ($this->services as $key => $service) {
            $filePath = $this->getBasePath()."/Services/{$service}.php";

            if (! file_exists($filePath)) {
                // Support for the .stub file extension
                $filePath .= '.stub';
            }

            $this->publishes([
                $filePath => "app/Services/{$service}.php",
            ], "{$this->id}-services");
        }
    }

    /**
     * Replace lines of files.
     *
     * @return void
     */
    protected function replaceLines()
    {
        foreach ($this->models as $key => $model) {
            Artisan::call('controlla:replace:lines', [
                '--model' => $model,
            ]);
        }
    }

    /**
     * Returns module configuration value(s)
     *
     * @param  string  $key  If left empty, the entire module configuration gets retrieved
     * @param  mixed  $default
     * @return mixed
     */
    public function config(?string $key = null, $default = null)
    {
        $key = $key ? sprintf('%s.%s', $this->getId(), $key) : $this->getId();

        return config($key, $default);
    }

    public static function generateMigrationName(string $migrationFileName, Carbon $now): string
    {
        $migrationsPath = 'migrations/'.dirname($migrationFileName).'/';
        $migrationFileName = basename($migrationFileName);

        $len = strlen($migrationFileName) + 4;

        if (Str::contains($migrationFileName, '/')) {
            $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
            $migrationFileName = Str::of($migrationFileName)->afterLast('/');
        }

        foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
            if ((substr($filename, -$len) === $migrationFileName.'.php')) {
                return $filename;
            }
        }

        return database_path($migrationsPath.$now->format('Y_m_d_His').'_'.Str::of($migrationFileName)->snake()->finish('.php'));
    }
}
