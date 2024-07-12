<?php

namespace Controlla\Core\Modules;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\ServiceProvider;
use Controlla\Core\Contracts\Controlla as ControllaContract;

abstract class BaseModuleServiceProvider extends ServiceProvider
{
  /** @var  string */
  protected $basePath;

  /** @var  string */
  protected $id;

  /** @var  string */
  protected $name;

  /** @var  string */
  protected $version;

  /** @var  string */
  protected $namespaceRoot;

  /** @var  ControllaContract */
  protected $controlla;

  /** @var  array */
  protected $migrations = [];

  /** @var  array */
  protected $models = [];

  /**
   * BaseModuleServiceProvider class constructor
   *
   * @param \Illuminate\Contracts\Foundation\Application $app
   */
  public function __construct($app)
  {
    parent::__construct($app);
    $this->controlla = $app->make(ControllaContract::class); // retrieve the controlla singleton
    $this->basePath = $this->controlla->getBasePath();
    $this->name = Str::title("{$this->id} Module");
    $this->namespaceRoot = "App\Modules\\" . Str::title($this->id);
  }

  /**
   * Bootstrap services.
   */
  public function boot(): void
  {
    $this->publishes([
      __DIR__ . "/config/{$this->id}.php" => config_path("{$this->id}.php")
    ], 'config');

    if ($this->areMigrationsEnabled()) {
      $this->registerMigrations();
    }

    if ($this->areModelsEnabled()) {
      $this->registerModels();
    }
  }

  /**
   * @inheritDoc
   */
  public function getId(): string
  {
    return $this->id;
  }

  /**
   * @inheritDoc
   */
  public function getName(): string
  {
    return $this->name;
  }

  /**
   * @inheritDoc
   */
  public function getVersion(): string
  {
    return $this->version;
  }

  /**
   * @inheritDoc
   */
  public function getNamespaceRoot(): string
  {
    return $this->namespaceRoot;
  }

  /**
   * Returns the root folder on the filesystem containing the module
   *
   * @return string
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

  /**
   * Register the module's migrations
   */
  protected function registerMigrations()
  {
    $now = Carbon::now();
    foreach ($this->migrations as $migration) {
      $filePath = $this->getBasePath() . "/database/migrations/{$this->id}/{$migration}.php";

      if (!file_exists($filePath)) {
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
      $filePath = $this->getBasePath() . "/app/Models/{$this->id}/{$model}.php";

      if (!file_exists($filePath)) {
        // Support for the .stub file extension
        $filePath .= '.stub';
      }

      $this->publishes([
        $filePath => "app/Models/{$model}.php",
      ], "{$this->id}-models");
    }
  }

  /**
   * Returns module configuration value(s)
   *
   * @param string $key If left empty, the entire module configuration gets retrieved
   * @param mixed  $default
   *
   * @return mixed
   */
  public function config(string $key = null, $default = null)
  {
    $key = $key ? sprintf('%s.%s', $this->getId(), $key) : $this->getId();

    return config($key, $default);
  }

  public static function generateMigrationName(string $migrationFileName, Carbon $now): string
  {
    $migrationsPath = 'migrations/' . dirname($migrationFileName) . '/';
    $migrationFileName = basename($migrationFileName);

    $len = strlen($migrationFileName) + 4;

    if (Str::contains($migrationFileName, '/')) {
      $migrationsPath .= Str::of($migrationFileName)->beforeLast('/')->finish('/');
      $migrationFileName = Str::of($migrationFileName)->afterLast('/');
    }

    foreach (glob(database_path("{$migrationsPath}*.php")) as $filename) {
      if ((substr($filename, -$len) === $migrationFileName . '.php')) {
        return $filename;
      }
    }

    return database_path($migrationsPath . $now->format('Y_m_d_His') . '_' . Str::of($migrationFileName)->snake()->finish('.php'));
  }
}
