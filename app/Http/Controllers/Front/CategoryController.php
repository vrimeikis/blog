<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Front;

use App\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function articles(string $slug): View
    {
        $articles = Article::query()
            ->whereHas('categories', function(Builder $query) use ($slug) {
                $query->where('slug', '=', $slug);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('front.articles_list', [
            'articles' => $articles,
        ]);
    }
}
