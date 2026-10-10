<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:deploy')]
#[Description('Run database migrations and seed the default categories if there are none')]
class Deploy extends Command
{
    public function handle(): int
    {
        $connection = DB::connection();

        // Say where we're migrating, so a misconfigured deploy is obvious in the logs.
        $this->components->info(sprintf(
            'Deploying to database connection [%s] on host [%s], database [%s].',
            $connection->getName(),
            $connection->getConfig('host') ?? 'local file',
            $connection->getDatabaseName(),
        ));

        $this->call('migrate', ['--force' => true]);
        $this->call('db:seed', ['--force' => true]);

        return self::SUCCESS;
    }
}
