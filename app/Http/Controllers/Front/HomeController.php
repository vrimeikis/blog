<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Front;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $articles = Article::query()
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('front.home', [
            'articles' => $articles,
        ]);
    }
}
