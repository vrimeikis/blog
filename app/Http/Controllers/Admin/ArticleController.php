<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Requests\ArticleStoreRequest;
use App\Services\ArticleService;
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
     * @var ArticleService
     */
    private $articleService;

    /**
     * ArticleController constructor.
     * @param ArticleService $articleService
     */
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $paginatedArticles = $this->articleService->getPaginateData();

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
        $this->articleService->createNewArticle(
            $request->getTitle(),
            $request->getContext(),
            $request->getSlug(),
            $request->getCategoriesIds(),
            $request->getCover()
        );

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
        $article = $this->articleService->getById($id);
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
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ArticleStoreRequest $request, int $id): RedirectResponse
    {
        $this->articleService->updateById(
            $id,
            $request->getTitle(),
            $request->getContext(),
            $request->getSlug(),
            $request->getCategoriesIds(),
            $request->getDeleteCoverOption(),
            $request->getCover()
        );

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
        $this->articleService->destroyById($id);

        return redirect()->route('admin.articles.index')
            ->with('status', 'Article deleted!');
    }
}
