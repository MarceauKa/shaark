<?php

namespace App\Providers;

use App\Services\Hashid;
use App\Services\Shaarli\Shaarli;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
        }

        $this->app->singleton(Shaarli::class, function ($app) {
            return new Shaarli($app);
        });

        $this->app->alias(Shaarli::class, 'shaarli');

        $this->app->singleton(Hashid::class, function ($app) {
            return new Hashid($app['config']->get('shaarli.hashids'));
        });

        $this->app->alias(Hashid::class, 'hashid');
    }

    public function boot()
    {
        $this->app->setLocale(app('shaarli')->getLocale());

        View::composer('layouts.partials.scripts', function (\Illuminate\View\View $view) {
            $locale = config('app.locale');

            if ($locale !== 'en') {
                $path = resource_path(sprintf('lang/%s.json', $locale));

                try {
                    $view->with('lang', json_decode(file_get_contents($path)));
                } catch (\Exception $e) {
                    throw new \RuntimeException('Unable to load i18n file.');
                }
            } else {
                $view->with('lang', []);
            }
        });

        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });
    }
}
