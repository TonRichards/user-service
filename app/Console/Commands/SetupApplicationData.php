<?php

namespace App\Console\Commands;

use App\Models\Application;
use App\Enums\ApplicationEnum;
use Illuminate\Console\Command;

class SetupApplicationData extends Command
{
    protected $signature = 'setup:application-data';

    protected $description = 'Setup application data';

    public function handle()
    {
        foreach(ApplicationEnum::values() as $application) {
            Application::updateOrCreate([
                'name' => $application
            ], [
                'name' => $application,
                'display_name' => ucfirst(str_replace('_', ' ', $application))
            ]);
        }
    }
}
