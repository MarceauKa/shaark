<?php

Artisan::command('shaarli:install', function () {
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
    $email = $this->ask('User email?', 'admin@example.com');
    $pass = $this->secret('User pass? (secret)', 'secret');

    $user = \App\User::count() ? \App\User::first() : new \App\User();

    $user->fill([
        'name' => $name,
        'email' => $email,
        'password' => \Illuminate\Support\Facades\Hash::make('pass'),
        'api_token' => $pass === 'secret' ? 'api-token-secret' : \App\User::generateApiToken(),
    ]);

    $user->save();
    $this->comment('User udpated');

    $this->comment('Installation done');
});

Artisan::command('shaarli:self-update', function () {
    $this->comment('Down artisan');
    $this->callSilent('down');
    $this->comment('Git update.');
    exec('git reset --hard >> /dev/null 2>&1');
    exec('git pull origin master >> /dev/null 2>&1');
    $this->comment('Composer update.');
    exec('composer install >> /dev/null 2>&1');
    $this->comment('Migrations');
    exec('php artisan migrate --force -n >> /dev/null 2>&1');
    $this->comment('Routines');
    $this->callSilent('cache:clear');
    $this->callSilent('config:cache');
    $this->callSilent('route:cache');
    $this->callSilent('view:clear');
    $this->comment('Assets');
    exec('npm install >> /dev/null 2>&1');
    exec('npm run prod >> /dev/null 2>&1');
    $this->comment('Up artisan');
    $this->callSilent('up');
})->describe('Self update');
