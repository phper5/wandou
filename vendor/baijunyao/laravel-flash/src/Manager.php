<?php

namespace Baijunyao\LaravelFlash;

use Baijunyao\LaravelPluginManager\Contracts\PluginManager;

class Manager extends PluginManager
{
    protected $element = 'body';

    protected function load()
    {
        $init = '';
        // 自定义提示信息
        if (session()->has('laravel-flash')) {
            $laravelFlash = array_unique(session('laravel-flash'), SORT_REGULAR);
            foreach ($laravelFlash as $k => $v) {
                $init .= 'toastr.'.$v['alert-type'].'("'.$v['alert-message'].'");';
            }
        }
        
        // Validate 表单验证的错误信息
        if (session()->has('errors')) {
            foreach (session('errors')->all() as $k => $v) {
                $init .= 'toastr.error'.'("'.$v.'");';
            }
        }

        $this->cssContent(toastr_css())
            ->jsContent(toastr_js())
            ->jsContent($init);
    }

    /**
     * 判断是否有需要弹出提示的内容
     * 
     * @return bool
     */
    public function verify()
    {
        // 检查是否有提示内容
        if (session()->has('laravel-flash') || session()->has('errors')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 清理动作
     */
    public function clean()
    {
        flash_clear();
    }
}