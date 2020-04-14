<?php

declare(strict_types=1);

namespace App\Models;

/**
 * App\Models\ArticleDownload
 *
 * @property int                             $id
 * @property int                             $article_id
 * @property string                             $url
 * @property string                             $title
 * @property int                             $size
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Article $article
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base disableCache()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDownload newModelQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDownload newQuery()
 * @method static \GeneaLabs\LaravelModelCaching\CachedBuilder|\App\Models\ArticleDownload query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereArticleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereMarkdown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleDownload whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Base withCacheCooldownSeconds($seconds = null)
 * @mixin \Eloquent
 */
class ArticleDownload extends Base
{
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
