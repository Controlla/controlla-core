<?php

namespace Controlla\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Controlla\Core\Contracts\Controlla;
use Controlla\Core\Modules\BaseModuleServiceProvider;

class ModulesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'controlla:modules {--a|all : List all modules, including implicit ones}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List Controlla Modules';

    protected $headers = ['#', 'Name', 'Version', 'Id', 'Namespace'];

    /**
     * Execute the console command.
     */
    public function handle(Controlla $controlla)
    {
        $modules = $controlla->getModules((bool) $this->option('all'));

        if ($modules->count()) {
            $this->showModules($modules);
        } else {
            $this->line('No modules have been registered. Add one in config/controlla.php.');
        }
    }

    /**
     * Displays the list of modules on the output
     *
     * @param  $modules  Collection
     */
    protected function showModules(Collection $modules)
    {
        $table = [];
        $i = 0;

        /** @var BaseModuleServiceProvider $module */
        foreach ($modules as $module) {
            $i++;

            $table[] = [
                'no' => sprintf('%d.', $i),
                'name' => $module->getName(),
                'version' => $module->getVersion(),
                'id' => $module->getId(),
                'namespace' => $module->getNamespaceRoot(),
            ];
        }

        $this->table($this->headers, $table);
    }
}
