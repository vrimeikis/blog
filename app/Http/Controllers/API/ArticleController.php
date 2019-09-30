<?php

declare(strict_types = 1);

namespace App\Http\Controllers\API;

use App\Exceptions\EmptyDataException;
use App\Http\Requests\ApiArticleStoreRequest;
use App\Services\ArticleService;
use Error;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Throwable;

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
        try {
            $articles = $this->articleService->getPaginateDataDTO();

            return response()->json($articles);
        } catch (EmptyDataException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], $exception->getCode());
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Something wrong!'
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
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
        try {
            $article = $this->articleService->getBySlug($slug);

            return response()->json($article);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Not found data by slug!',
            ], JsonResponse::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Something wrong!',
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        } catch (Error $error) {
            return response()->json([
                'success' => false,
                'message' => 'Fatal error',
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }

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
