<?php

namespace Controlla\Core\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use function Laravel\Prompts\select;

class ModuleCommand extends Command implements PromptsForMissingInput
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'controlla:module {module}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Install Controlla Module';

  /**
   * The filesystem instance.
   *
   * @var \Illuminate\Filesystem\Filesystem
   */
  protected $files;

  /**
   * Create a new controller creator command instance.
   *
   * @param  \Illuminate\Filesystem\Filesystem  $files
   * @return void
   */
  public function __construct(Filesystem $files)
  {
    parent::__construct();

    if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
      $this->addTestOptions();
    }

    $this->files = $files;
  }

  /**
   * Execute the console command.
   */
  public function handle()
  {
    $this->comment("Publishing {$this->getModuleInput()} module...");

    $this->registerModule();

    $this->callSilently("vendor:publish", [
      '--provider' => $this->getModule(),
    ]);

    if ($this->confirm('Would you like to run the migrations now?')) {
      $this->comment('Running migrations...');

      $this->call('migrate');
    }

    $this->components->info(sprintf('Controlla Module [%s] created successfully.', $this->getModule()));
  }


  /**
   * Prompt for missing input arguments using the returned questions.
   *
   * @return array
   */
  protected function promptForMissingArgumentsUsing()
  {
    return [
      'module' => fn () => select(
        label: 'Which module do you want to install?',
        options: ['Whatsapp'],
        default: 'Whatsapp'
      ),
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
    $name = Str::replaceFirst($this->rootNamespace(), '', $name);

    return $this->laravel['path'] . '/' . str_replace('\\', '/', $name) . '.php';
  }

  /**
   * Get the desired module name from the input.
   *
   * @return string
   */
  protected function getModuleInput()
  {
    return trim($this->argument('moduele'));
  }

  /**
   * Get the desired class name from the input.
   *
   * @return string
   */
  protected function getModule()
  {
    return sprintf('Controlla\Core\Modules\%s\%sModuleServiceProvider', $this->getModuleInput(), $this->getModuleInput());
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
   * Register module.
   *
   * @return string
   */
  protected function registerModule()
  {
    $path = $this->getPath('config/controlla.php');
    $file = $this->files->get($path);
    $this->files->put($path, str_replace("// New Module", $this->getModule() . '\n// New Module', $file));
  }
}
