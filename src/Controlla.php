<?php

namespace Controlla\Core;

use Controlla\Core\Contracts\Controlla as ControllaContract;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use ReflectionClass;

class Controlla implements ControllaContract
{
    /** @var Collection */
    protected $modules;

    /** @var array */
    protected $implicitModules = [];

    /** @var Application */
    protected $app;

    /** @var string */
    protected $basePath;

    /**
     * Controlla class constructor
     */
    public function __construct(Application $app)
    {
        $this->basePath = dirname(dirname(dirname((new ReflectionClass(static::class))->getFileName())));
        $this->modules = Collection::make();
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function registerModule($moduleClass, $config = [])
    {
        /** @var WhatsappModuleServiceProvider */
        $module = $this->app->register($moduleClass);

        $this->modules->put($module->getId(), $module);
        $implicit = $config['implicit'] ?? false;

        if ($implicit) {
            $this->implicitModules[get_class($module)] = true;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getModules($includeImplicits = false): Collection
    {
        if ($includeImplicits) {
            return $this->modules;
        }

        $implicitModules = $this->implicitModules;

        return $this->modules->reject(function ($module) use ($implicitModules) {
            return array_key_exists(get_class($module), $implicitModules);
        });
    }

    /**
     * Returns the root folder on the filesystem containing the module
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }
}
