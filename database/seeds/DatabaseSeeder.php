<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Mail::fake();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'shaark@example.com',
            'password' => Hash::make('secret'),
            'api_token' => 'api-token-secret',
            'is_admin' => 1,
            'created_at' => now()->toDateTimeString(),
        ]);
    }
}
