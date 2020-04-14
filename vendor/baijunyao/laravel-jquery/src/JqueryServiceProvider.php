<?php

namespace Baijunyao\LaravelJquery;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class JqueryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // 发布静态资源文件
        $this->publishes([
            __DIR__.'/resources/statics' => public_path('statics'),
        ], 'public');

        // 定义 jquery js 标签
        Blade::directive('jquery', function ($version) {
            $version = str_replace(['"', "'", ' '], '', $version);
            $version = empty($version) ? '1.12.4' : $version;
            return Jquery::tag($version);
        });
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
