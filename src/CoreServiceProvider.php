<?php

namespace Controlla\Core;

use Controlla\Core\Controlla;
use Spatie\LaravelPackageTools\Package;
use Controlla\Core\Commands\ModuleCommand;
use Controlla\Core\Commands\ModulesCommand;
use Controlla\Core\Commands\LangMakeCommand;
use Controlla\Core\Commands\TruncateCommand;
use Controlla\Core\Commands\ModelMakeCommand;
use Controlla\Core\Commands\ScopeMakeCommand;
use Controlla\Core\Commands\ExportMakeCommand;
use Controlla\Core\Commands\ImportMakeCommand;
use Controlla\Core\Commands\PolicyMakeCommand;
use Controlla\Core\Commands\RequestMakeCommand;
use Controlla\Core\Commands\ServiceMakeCommand;
use Controlla\Core\Commands\NewComponentCommand;
use Controlla\Core\Commands\ReplaceLinesCommand;
use Controlla\Core\Commands\ResourceMakeCommand;
use Controlla\Core\Commands\ControllerMakeCommand;
use Controlla\Core\Commands\RepositoryMakeCommand;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Controlla\Core\Commands\ServiceInterfaceMakeCommand;
use Controlla\Core\Commands\RepositoryInterfaceMakeCommand;
use Controlla\Core\Contracts\Controlla as ControllaContract;

class CoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('controlla-core')
            ->hasConfigFile('controlla')
            ->hasMigration('create_controlla_logs_table')
            ->hasCommands([
                TruncateCommand::class,
                ControllerMakeCommand::class,
                ExportMakeCommand::class,
                ImportMakeCommand::class,
                PolicyMakeCommand::class,
                ModelMakeCommand::class,
                LangMakeCommand::class,
                ServiceMakeCommand::class,
                ServiceInterfaceMakeCommand::class,
                RepositoryMakeCommand::class,
                RepositoryInterfaceMakeCommand::class,
                NewComponentCommand::class,
                RequestMakeCommand::class,
                ResourceMakeCommand::class,
                ReplaceLinesCommand::class,
                ScopeMakeCommand::class,
                ModuleCommand::class,
                ModulesCommand::class,
            ]);
    }

    public function packageRegistered()
    {
        // New Singleton
        $this->app->singleton(ControllaContract::class, Controlla::class);

        // Make an instance
        $controllaInstance = $this->app->make(ControllaContract::class);
        // And make it available as the 'controlla' service
        $this->app->instance('controlla', $controllaInstance);

        $modules = config("controlla.modules") ?: [];


        foreach ($modules as $key => $value) {
            $module = is_string($key) ? $key : $value;
            $config = is_array($value) ? $value : [];
            $controllaInstance->registerModule($module, $config);
        }
        // if ($this->app->runningInConsole()) {
        //     $this->app->extend('command.make.model', function () {
        //         return new ModelMakeCommand;
        //     });
        // }
    }
}
