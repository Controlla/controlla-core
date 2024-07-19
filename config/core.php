<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Prune Logs Duration
    |--------------------------------------------------------------------------
    |
    | Duration in which logs will be deleted periodically
    | that are no longer needed. You should schedule the model:prune
    | Artisan command in your application's App\Console\Kernel class.
    | You are free to specify the appropriate interval here at which
    | this command should be run:
    | ```
    | $schedule->command('model:prune', [
    |   '--model' => [Controlla\Core\Models\Log::class],
    | ])->daily();
    |
    */

    'prune_logs_duration' => env('PRUNE_LOGS_DURATION', now()->subMonth()),
];
