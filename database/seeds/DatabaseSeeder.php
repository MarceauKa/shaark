<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Event::fake();
        Mail::fake();

        DB::table('users')->insert([
            'name' => 'Marceau Ka',
            'email' => 'admin@example.fr',
            'password' => Hash::make('secret'),
            'api_token' => 'api-token-secret',
            'created_at' => now()->toDateTimeString(),
        ]);
    }
}
