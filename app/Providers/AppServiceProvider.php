<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->environment('production')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    public function boot()
    {
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
    }
}
