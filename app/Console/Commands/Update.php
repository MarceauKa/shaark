<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Update extends Command
{
    protected $signature = 'shaarli:update';
    protected $description = 'Shaarli updater';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (false === $this->testSystem()) {
            $this->info("Can't proceed to update.");
            return;
        }

        // Down
        $this->call('down');

        // Git
        $this->comment('Resetting git');
        exec('git reset --hard HEAD >> /dev/null 2>&1');
        $this->comment('Pulling changes');
        exec('git pull origin master >> /dev/null 2>&1');

        // Composer
        $this->comment('Composer install');
        exec('composer install --no-dev >> /dev/null 2>&1');
        exec('composer dump-autoload -o >> /dev/null 2>&1');

        // Migrations
        $this->callSilent('migrate', [
            '--force' => true,
        ]);
        $this->comment('Migrated');

        // Optimizations
        $this->callSilent('storage:link');
        $this->callSilent('optimize');
        $this->callSilent('view:clear');
        $this->callSilent('queue:restart');

        // Up
        $this->call('up');

        $this->info('Update finished!');
    }

    protected function testSystem(): bool
    {
        exec('git --version', $git);
        exec('composer --version', $composer);

        if (empty($git)) {
            $this->error('Git is not available.');
            return false;
        }

        if (empty($composer)) {
            $this->error('Composer is not available.');
            return false;
        }

        return true;
    }
}
