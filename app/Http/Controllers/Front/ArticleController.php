<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Front;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function show(string $slug): View
    {
        $article = Article::query()
            ->where('slug', '=', $slug)
            ->first();

        return view('front.articles_show', [
            'article' => $article,
        ]);
    }
}
