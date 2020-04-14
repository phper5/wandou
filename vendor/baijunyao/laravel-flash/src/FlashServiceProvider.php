<?php

namespace Baijunyao\LaravelFlash;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Baijunyao\LaravelFlash\Middleware\LaravelFlash;

class FlashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布配置项
        $this->publishes([
            __DIR__.'/config/laravel-flash.php' => config_path('laravel-flash.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
