<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('restricted', function (?User $user) {
            if (app('shaark')->getIsPrivate() === false) {
                return true;
            }

            return !empty($user);
        });

        Gate::define('comments.see', function (?User $user) {
            return app('shaark')->authorizedToSee(request());
        });

        Gate::define('comments.add', function (?User $user) {
            return app('shaark')->authorizedToAdd(request());
        });
    }
}
