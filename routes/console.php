<?php

use Illuminate\Support\Facades\Schedule;

// Housekeeping, run by `php artisan schedule:work` (see DEPLOYMENT.md).
Schedule::command('auth:clear-resets')->daily();
Schedule::command('queue:prune-failed', ['--hours' => 24 * 7])->daily();
