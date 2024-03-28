<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ShieldCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'UpdatePermissions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create Policies and SuperAdmin';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Artisan::call('shield:generate --all');
        Artisan::call('shield:super-admin --user=1');
    }
}
