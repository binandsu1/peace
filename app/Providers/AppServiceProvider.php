<?php

namespace App\Providers;

use App\Services\Mgc;
use App\Services\Weibo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Routing\UrlGenerator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('mgc', function () {
            return new Mgc();
        });
        $this->app->singleton('weibo', function () {
            return new Weibo();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(UrlGenerator $url)
    {
        $env = env('APP_ENV');
        if($env != 'local'){
            $url->forceScheme('https');
        }
    }
}
