<?php

declare(strict_types=1);

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ActorController extends Controller
{
    public function show(Actor $actor)
    {
        DB::enableQueryLog();
        $articles = $actor->articles()
            ->orderBy('created_at', 'desc')
            ->with('tags')
            ->paginate(10);
//        echo 'xx';
//        $list = $actor->articles();
//        //echo count($list);
//        echo $list->count();
//        echo $articles->currentPage();
//        $log = DB::getQueryLog();
//        print_r($log);exit;
        if ($articles->isNotEmpty()) {
            $articles->setCollection(
                collect(
                    $articles->items()
                )->map(function ($v)  {
                    //$v->category = $category;

                    return $v;
                })
            );
        }
        $head = [
            'title'       => $actor->name,
            'keywords'    => $actor->name,
            'description' => $actor->name,
        ];
        $assign = [
            'actor_id'  => $actor->id,
            'articles'     => $articles,
            'tagName'      => '',
            'title'        => $actor->name,
            'head'         => $head,
        ];

        return view('home.index.index', $assign);
    }
}
