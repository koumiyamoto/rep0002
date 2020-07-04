<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 本番環境でHTTPS を強制
        if (\App::environment('production')) {
            \URL::forceScheme('https');
        }

        // varchar型の文字数を191に制限
        Schema::defaultStringLength(191);
    }
}
