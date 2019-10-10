<?php

namespace App\Listeners;

use App\User;
use Illuminate\Database\Events\MigrationEnded;
use Illuminate\Support\Facades\DB;

class UpdateDatabase
{
    /** @var array $updaters */
    protected $updaters = [
        \AddUserToPostsTable::class => 'addDefaultUserToPosts',
        \AddIsAdminToUsersTable::class => 'setIsAdminToFirstUser',
    ];

    public function handle(MigrationEnded $event)
    {
        $class = get_class($event->migration);

        if ($event->method === 'up' && array_key_exists($class, $this->updaters)) {
            $method = $this->updaters[$class];

            if (method_exists($this, $method)) {
                $this->$method();
            }
        }
    }

    protected function addDefaultUserToPosts()
    {
        $user = User::first();

        if (empty($user)) {
            return;
        }

        DB::table('posts')->update([
            'user_id' => $user->id,
        ]);
    }

    protected function setIsAdminToFirstUser()
    {
        $user = User::first();

        if (empty($user)) {
            return;
        }

        DB::table('users')->update([
            'is_admin' => 1,
        ]);
    }
}
