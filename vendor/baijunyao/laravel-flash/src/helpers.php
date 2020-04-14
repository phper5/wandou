<?php

if (!function_exists('flash_success')){
    /**
     * 添加成功提示
     *
     * @param string $message  提示内容
     * @param bool   $flash    当为 true 的时候会触发提示 此参数是为了方便在外部调用的时减少判断
     *                         例如原本的if判断场景:
     *                         if($needFlash) {
     *                              flash_success('成功')
     *                         }
     *                         用此参数可以简化成
     *                         flash_success('成功', $needFlash)
     *
     */
    function flash_success($message = '成功', $flash = true)
    {
        if ($flash) {
            $data = [
                'alert-message' => $message,
                'alert-type' => 'success'
            ];
            Session::push('laravel-flash', $data);
        }
    }
}

if (!function_exists('flash_error')){
    /**
     * 添加失败提示
     *
     * @param string $message  提示内容
     * @param bool   $flash    当为 true 的时候会触发提示 此参数是为了方便在外部调用的时减少判断
     *                         例如原本的if判断场景:
     *                         if($needFlash) {
     *                              flash_error('失败')
     *                         }
     *                         用此参数可以简化成
     *                         flash_error('失败', $needFlash)
     */
    function flash_error($message = '失败', $flash = true)
    {
        if ($flash) {
            $data = [
                'alert-message' => $message,
                'alert-type' => 'error'
            ];
            Session::push('laravel-flash', $data);
        }
    }
}

if (!function_exists('flash_clear')){
    /**
     * 删除提示
     */
    function flash_clear()
    {
        Session::remove('laravel-flash');
    }
}
