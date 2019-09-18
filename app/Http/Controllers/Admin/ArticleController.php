<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use App\Http\Requests\ArticleStoreRequest;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
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
        /** @var Article $article */
        $article = Article::create([
            'title' => $request->getTitle(),
            'content' => $request->getContext(),
            'slug' => $request->getSlug(),
        ]);

        $article->categories()->attach($request->getCategoriesIds());

        $cover = $request->getCover();
        if ($cover !== null) {
            $uploadedFile = $cover->store('article/'.$article->id);
            $article->cover = $uploadedFile;
            $article->save();
        }


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
        $article = Article::with('categories')->find($id);
        $categories = Category::orderBy('title')
            ->pluck('title', 'id');

        return view('admin.article.edit', [
            'article' => $article,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleStoreRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(ArticleStoreRequest $request, Article $article): RedirectResponse
    {
        $article->update([
            'title' => $request->getTitle(),
            'content' => $request->getContext(),
            'slug' => $request->getSlug()
        ]);

        $article->categories()->sync($request->getCategoriesIds());

        if ($request->getDeleteCoverOption() !== null) {
            Storage::delete($article->cover);
            $article->cover = null;
            $article->save();
        }

        $cover = $request->getCover();
        if ($cover !== null) {
            $uploadedFile = $cover->store('article/'.$article->id);
            $article->cover = $uploadedFile;
            $article->save();
        }

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
