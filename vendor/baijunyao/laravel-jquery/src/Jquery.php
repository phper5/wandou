<?php

namespace Baijunyao\LaravelJquery;

class Jquery
{

    /**
     * 返回 jquery 的路径
     *
     * @param string $version
     *
     * @return string
     */
    public static function path($version = '1.12.4')
    {
        return asset('statics/jquery/'.$version.'/jquery.min.js');
    }

    /**
     * 返回 jquery 标签
     *
     * @param string $version
     *
     * @return string
     */
    public static function tag($version = '1.12.4')
    {
        $path = self::path($version);
        return "<script src='$path'></script>";
    }

    /**
     * 返回可以避免重复的 jquery 标签
     *
     * @param string $version
     *
     * @return string
     */
    public static function unique($version = '1.12.4')
    {
        $path = self::path($version);
        $script = <<<php
<script>
    (function(){
        window.jQuery || document.write("<script src='$path'><\/script>");
    })();
</script>
php;

        return $script;
    }

}