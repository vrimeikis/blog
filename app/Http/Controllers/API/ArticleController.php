<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API;

use App\Http\Requests\ApiArticleStoreRequest;
use App\Services\ArticleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * Class ArticleController
 * @package App\Http\Controllers\API
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
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $articles = $this->articleService->getPaginateData();

        return response()->json($articles);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ApiArticleStoreRequest $request
     * @return JsonResponse
     */
    public function store(ApiArticleStoreRequest $request): JsonResponse
    {
        $article = $this->articleService->createNewArticle(
            $request->getTitle(),
            $request->getContext(),
            $request->getSlug(),
            $request->getCategoriesIds(),
            $request->getCover()
        );

        return response()->json($article);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug
     * @return JsonResponse
     */
    public function show(string $slug): JsonResponse
    {
        $article = $this->articleService->getBySlug($slug);

        return response()->json($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
