<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetForDemo extends Command
{
    protected $signature = 'shaarli:reset';
    protected $description = 'Reset app for demo';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $this->callSilent('down', [
            '--message' => 'App is being resetted',
        ]);

        $this->callSilent('migrate:fresh', [
            '--force' => true,
            '--no-interaction' => true,
            '--seed' => true
        ]);

        $this->callSilent('up');
    }
}
