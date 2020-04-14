<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleArea;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

class AreaController extends Controller
{
    public function show()
    {
        $area = Route::input('area');
        $articles = Article::leftJoin('article_areas','articles.id','=','article_areas.article_id')->where('article_areas.title','like','%'.$area.'%')
            ->orderBy('article_areas.created_at', 'desc')
            ->with('tags')
            ->paginate(10);

        if ($articles->isNotEmpty()) {
            $articles->setCollection(
                collect(
                    $articles->items()
                )->map(function ($v)  {
                    //$v->area = $area;

                    return $v;
                })
            );
        }

        $head = [
            'title'       => $area,
            'keywords'    => $area,
            'description' => $area,
        ];
        $assign = [
//            'area_id'  => $area->id,
            'articles'     => $articles,
            'tagName'      => '',
            'title'        => $area,
            'head'         => $head,
        ];

        return view('home.index.index', $assign);
    }
}
