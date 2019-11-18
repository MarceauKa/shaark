<?php

namespace App\Providers;

use App\Services\Hashid;
use App\Services\Shaark\Shaark;
use App\Services\UpdateChecker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

        $this->app->singleton(Shaark::class, function ($app) {
            return new Shaark($app);
        });

        $this->app->alias(Shaark::class, 'shaark');

        $this->app->singleton(Hashid::class, function ($app) {
            return new Hashid($app['config']->get('shaark.hashids'));
        });

        $this->app->alias(Hashid::class, 'hashid');
    }

    public function boot()
    {
        $this->app->setLocale(app('shaark')->getLocale());

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

        View::composer('layouts.partials.footer', function (\Illuminate\View\View $view) {
            $version = Cache::remember('version', Carbon::now()->addDay(), function () {
                $checker = UpdateChecker::check();

                return $checker->latest;
            });

            $view->with('version', json_encode($version));
        });

        Validator::extend('current_password', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, Auth::user()->getAuthPassword());
        });

        Validator::extend('temp_image', function ($attribute, $value, $parameters, $validator) {
            return Storage::exists($value);
        });
    }
}
