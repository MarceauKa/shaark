<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Install extends Command
{
    protected $signature = 'shaark:install';
    protected $description = 'Shaark installer';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        if (false === $this->confirm('All existing data will be erased')) {
            $this->comment('Ok. Bye.');
            return;
        }

        $this->comment('Migrations');
        $this->callSilent('migrate:fresh');

        if ($this->confirm('Default data?')) {
            $this->callSilent('db:seed');
            exec('php artisan scout:import ' . \App\Link::class);
        }

        $name = $this->ask('User name?', 'Admin');
        $email = $this->ask('User email?', 'shaark@example.com');
        $pass = $this->ask('User pass?', 'secret');

        $user = \App\User::count() ? \App\User::first() : new \App\User();

        $user->fill([
            'name' => $name,
            'email' => $email,
            'password' => \Illuminate\Support\Facades\Hash::make($pass),
            'api_token' => $pass === 'secret' ? 'api-token-secret' : \App\User::generateApiToken(),
        ]);

        $user->save();
        $this->comment('User udpated');

        $this->comment('Installation done');
    }
}
