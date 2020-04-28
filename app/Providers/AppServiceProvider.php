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
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerHttps();
        $this->registerContainer();
    }

    public function boot()
    {
        $this->bootLocale();
        $this->bootViewComposer();
        $this->bootCustomValidation();
    }

    protected function registerHttps(): self
    {
        $url = $this->app['config']->get('app.url');

        if (Str::contains($url, 'https')) {
            $this->app['request']->server->set('HTTPS', true);
        }

        return $this;
    }

    protected function registerContainer(): self
    {
        $this->app->singleton(
            Shaark::class,
            function ($app) {
                return new Shaark($app);
            }
        );

        $this->app->alias(Shaark::class, 'shaark');

        $this->app->singleton(
            Hashid::class,
            function ($app) {
                return new Hashid($app['config']->get('shaark.hashids'));
            }
        );

        $this->app->alias(Hashid::class, 'hashid');

        return $this;
    }

    protected function bootLocale(): self
    {
        $this->app->setLocale(app('shaark')->getLocale());

        return $this;
    }

    protected function bootViewComposer(): self
    {
        View::composer(
            'layouts.partials.scripts',
            function (\Illuminate\View\View $view) {
                $locale = app('shaark')->getLocale() ?? 'en';

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
            }
        );

        View::composer(
            'layouts.partials.footer',
            function (\Illuminate\View\View $view) {
                $version = Cache::remember(
                    'version',
                    Carbon::now()->addDay(),
                    function () {
                        $checker = UpdateChecker::check();

                        return $checker->latest;
                    }
                );

                $view->with('version', json_encode($version));
            }
        );

        return $this;
    }

    protected function bootCustomValidation(): self
    {
        Validator::extend(
            'current_password',
            function ($attribute, $value, $parameters, $validator) {
                return Hash::check($value, Auth::user()->getAuthPassword());
            }
        );

        Validator::extend(
            'temp_image',
            function ($attribute, $value, $parameters, $validator) {
                return Storage::exists($value);
            }
        );

        return $this;
    }
}
