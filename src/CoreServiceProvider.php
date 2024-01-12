<?php

namespace Controlla\Core;

use Controlla\Core\Commands\ControllerMakeCommand;
use Controlla\Core\Commands\ExportMakeCommand;
use Controlla\Core\Commands\ImportMakeCommand;
use Controlla\Core\Commands\LangMakeCommand;
use Controlla\Core\Commands\ModelMakeCommand;
use Controlla\Core\Commands\NewComponentCommand;
use Controlla\Core\Commands\PolicyMakeCommand;
use Controlla\Core\Commands\ReplaceLinesCommand;
use Controlla\Core\Commands\RepositoryInterfaceMakeCommand;
use Controlla\Core\Commands\RepositoryMakeCommand;
use Controlla\Core\Commands\RequestMakeCommand;
use Controlla\Core\Commands\ResourceMakeCommand;
use Controlla\Core\Commands\ScopeMakeCommand;
use Controlla\Core\Commands\ServiceInterfaceMakeCommand;
use Controlla\Core\Commands\ServiceMakeCommand;
use Controlla\Core\Commands\TruncateCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->name('core')
            ->hasConfigFile()
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
            ]);
    }

    public function packageRegistered()
    {
        // if ($this->app->runningInConsole()) {
        //     $this->app->extend('command.make.model', function () {
        //         return new ModelMakeCommand;
        //     });
        // }
    }
}
