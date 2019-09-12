<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;

/**
 * Class ArticleController
 * @package App\Http\Controllers\Admin
 */
class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $paginatedArticles = Article::paginate();

        return view('admin.article.list', [
            'articles' => $paginatedArticles,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        $categories = Category::orderBy('title')
            ->pluck('title', 'id');

        return view('admin.article.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ArticleStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleStoreRequest $request): RedirectResponse
    {
        Article::create([
            'title' => $request->getTitle(),
            'content' => $request->getContext(),
        ]);

        return redirect()->route('admin.articles.index')
            ->with('status', 'Article created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $article = Article::find($id);

        return view('admin.article.edit', ['article' => $article]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleStoreRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ArticleStoreRequest $request, int $id): RedirectResponse
    {
        Article::where('id', '=', $id)->update([
            'title' => $request->getTitle(),
            'content' => $request->getContext(),
        ]);

        return redirect()->route('admin.articles.index')
            ->with('status', 'Article updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        Article::where('id', '=', $id)->delete();

        return redirect()->route('admin.articles.index')
            ->with('status', 'Article deleted!');
    }
}
