<?php

declare(strict_types=1);

namespace App\Models;

/**
 * App\Models\ArticleActor
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
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleActor newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleActor newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleActor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleActor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base withCacheCooldownSeconds($seconds = null)
 * @mixin \Eloquent
 */
class ArticleActor extends Base
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
