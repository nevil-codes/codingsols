<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:deploy')]
#[Description('Run database migrations and seed the default categories if there are none')]
class Deploy extends Command
{
    public function handle(): int
    {
        $this->call('migrate', ['--force' => true]);
        $this->call('db:seed', ['--force' => true]);

        return self::SUCCESS;
    }
}
