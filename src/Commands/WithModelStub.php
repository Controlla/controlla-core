<?php

namespace Controlla\Core\Commands;

use Illuminate\Support\Str;
use InvalidArgumentException;

trait WithModelStub
{
    /**
     * Build the model replacement values.
     */
    protected function buildModelReplacements(array $replace): array
    {
        $modelClass = $this->parseModel($this->option('model'));

        return array_merge($replace, [
            'DummyFullModelClass' => $modelClass,
            'DummyModelClass' => class_basename($modelClass),
            '{{ model }}' => class_basename($modelClass),
            '{{model}}' => class_basename($modelClass),
            '{{ modelPlural }}' => Str::plural(class_basename($modelClass)),
            '{{modelPlural}}' => Str::plural(class_basename($modelClass)),
            '{{ modelVariableCamel }}' => lcfirst(Str::plural(class_basename($modelClass))),
            '{{modelVariableCamel}}' => lcfirst(Str::plural(class_basename($modelClass))),
            '{{ modelVariable }}' => lcfirst(class_basename($modelClass)),
            '{{modelVariable}}' => lcfirst(class_basename($modelClass)),
            '{{ modelVariablePlural }}' => Str::plural(Str::snake(class_basename($modelClass))),
            '{{modelVariablePlural}}' => Str::plural(Str::snake(class_basename($modelClass))),
            '{{ modelVariableParam }}' => Str::plural(Str::kebab(class_basename($modelClass))),
            '{{modelVariableParam}}' => Str::plural(Str::kebab(class_basename($modelClass))),
        ]);
    }

    /**
     * Get the fully-qualified model class name.
     *
     * @param  string  $model
     */
    protected function parseModel($model): string
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        $model = is_dir(app_path('Models'))
            ? $rootNamespace.'Models\\'.$model
            : $rootNamespace.$model;

        return $model;
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }
}
