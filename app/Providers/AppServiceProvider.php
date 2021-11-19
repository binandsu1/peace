<?php

namespace App\Providers;

use App\Services\Mgc;
use App\Services\Weibo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gjc', function () {
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
    public function boot()
    {
        //
    }
}
