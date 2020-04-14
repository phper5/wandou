<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ReleaseController extends Controller
{
    public function show(Request $request)
    {
        $release = Route::input('release');
        $articles = Article::where('release_time',$release)
            ->orderBy('created_at', 'desc')
            ->with('tags')
            ->paginate(10);
        echo $articles->total();
        if ($articles->isNotEmpty()) {
            $articles->setCollection(
                collect(
                    $articles->items()
                )->map(function ($v){
                    //$v->category = $category;

                    return $v;
                })
            );
        }

        $head = [
            'title'       => $release,
            'keywords'    => $release.'上映 电影',
            'description' => $release.'上映 电影',
        ];
        $assign = [
            'release'  => $release,
            'articles'     => $articles,
            'tagName'      => '',
            'head'         => $head,
        ];

        return view('home.index.index', $assign);
    }
}
