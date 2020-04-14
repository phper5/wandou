<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Actor
 *
 * @property int                             $id
 * @property int                             $cate
 * @property string                             $title
 * @property string                             $cover
 * @property string                             $url
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
class Piaohua  extends Model
{
    public $timestamps = false;
}
