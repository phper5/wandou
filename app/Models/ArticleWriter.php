<?php

declare(strict_types=1);

namespace App\Models;

/**
 * App\Models\ArticleDirector
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
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDirector newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDirector newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDirector query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDirector whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base withCacheCooldownSeconds($seconds = null)
 * @mixin \Eloquent
 */
class ArticleWriter extends Base
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
