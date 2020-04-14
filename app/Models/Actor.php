<?php

declare(strict_types=1);

namespace App\Models;

/**
 * App\Models\Actor
 *
 * @property int                             $id
 * @property int                             $article_id
 * @property int                             $actor_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Article $article
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Actor newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Actor newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\Actor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Actor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base withCacheCooldownSeconds($seconds = null)
 * @mixin \Eloquent
 */
class Actor extends Base
{
    public function articles()
    {
        /*
         * 第一个参数：要关联的表对应的类
         * 第二个参数：中间表的表名
         * 第三个参数：当前表跟中间表对应的外键
         * 第四个参数：要关联的表跟中间表对应的外键
         * */
        return $this->belongsToMany(Article::class,'article_actors','actor_id','article_id');

    }
}
