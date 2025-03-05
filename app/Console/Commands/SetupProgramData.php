<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SetupProgramData extends Command
{
    protected $signature = 'setup:program-data';

    protected $description = 'Setup program data';

    public function handle()
    {
        Artisan::call('setup:application-data');

        $this->info('Finished setting up application data');
    }
}
