<?php

namespace Baijunyao\LaravelToastr;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class ToastrServiceProvider extends ServiceProvider
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

        // 定义 toastr css 标签
        Blade::directive('toastrcss', function () {
            return toastr_css();
        });

        // 定义 toastr js 标签
        Blade::directive('toastrjs', function () {
            return toastr_js();
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
