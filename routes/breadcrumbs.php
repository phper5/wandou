<?php

declare(strict_types=1);

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use DaveJamesMiller\Breadcrumbs\BreadcrumbsGenerator;

Breadcrumbs::for('home.article.index', function (BreadcrumbsGenerator $trail) {
    $trail->push('Home', url('/'));
});

Breadcrumbs::for('home.category.show', function (BreadcrumbsGenerator $trail, Category $category) {
    $trail->parent('home.article.index');
    $trail->push($category->name, route('home.category.show', $category->id));
});
Breadcrumbs::for('home.area.show', function (BreadcrumbsGenerator $trail, $string) {
    $trail->parent('home.article.index');
    $trail->push($string, route('home.area.show', $string));
});
Breadcrumbs::for('home.release.show', function (BreadcrumbsGenerator $trail, $string) {
    $trail->parent('home.article.index');
    $trail->push($string, route('home.release.show',$string));
});
Breadcrumbs::for('home.actor.show', function (BreadcrumbsGenerator $trail, \App\Models\Actor $actor) {
    $trail->parent('home.article.index');
    $trail->push($actor->name, route('home.release.show',$actor->id));
});
Breadcrumbs::for('home.tag.show', function (BreadcrumbsGenerator $trail, Tag $tag) {
    $trail->parent('home.article.index');
    $trail->push($tag->name, route('home.tag.show', $tag->id));
});

Breadcrumbs::for('home.note.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('home.article.index');
    $trail->push(__('Note'), route('home.note.index'));
});

Breadcrumbs::for('home.chat.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('home.article.index');
    $trail->push(__('Note'), route('home.note.index'));
});

Breadcrumbs::for('home.openSource.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('home.article.index');
    $trail->push(__('Open Source'), route('home.openSource.index'));
});

Breadcrumbs::for('home.site.index', function (BreadcrumbsGenerator $trail) {
    $trail->parent('home.article.index');
    $trail->push(__('Site'), route('home.site.index'));
});

Breadcrumbs::for('home.article.show', function (BreadcrumbsGenerator $trail, Article $article) {
    $trail->parent('home.category.show', $article->cates[0]);
    $trail->push($article->title, route('home.tag.show', $article->id));
});

Breadcrumbs::for('home.article.search', function (BreadcrumbsGenerator $trail) {
    $trail->parent('home.article.index');
    $trail->push(__('Search'), route('home.article.search'));
});
