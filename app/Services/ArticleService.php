<?php

declare(strict_types = 1);

namespace App\Services;

use App\Article;
use App\Repositories\ArticleRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Class ArticleService
 * @package App\Services
 */
class ArticleService
{
    const FILE_DIR = 'article';

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticleService constructor.
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginateData(): LengthAwarePaginator
    {
        return $this->articleRepository->paginate();
    }

    public function createNewArticle(
        string $title,
        string $content,
        string $slug,
        array $categoriesIds = [],
        ?UploadedFile $cover = null
    ): Article {
        /** @var Article $article */
        $article = $this->articleRepository->create([
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
        ]);

        $this->syncCategories($article, $categoriesIds);

        if ($cover !== null) {
            $uploadedFile = $this->uploadImage($cover, $article->id);
            $article->cover = $uploadedFile;
            $article->save();
        }

        return $article;
    }

    /**
     * @param int $id
     * @return Article|Model|null
     */
    public function getById(int $id): ?Article
    {
        return $this->articleRepository->find($id);
    }

    public function updateById(
        int $id,
        string $title,
        string $content,
        string $slug,
        array $categoriesIds = [],
        ?int $deleteCover = null,
        ?UploadedFile $cover = null
    ): int {
        /** @var Article $article */
        $article = $this->articleRepository->makeQuery()->findOrFail($id);
        $uploadedFile = $article->cover;

        if ($deleteCover !== null) {
            Storage::delete($article->cover);
            $uploadedFile = null;
        }

        if ($cover !== null) {
            $uploadedFile = $this->uploadImage($cover, $article->id);
        }

        $updated = $this->articleRepository->update([
            'title' => $title,
            'content' => $content,
            'slug' => $slug,
            'cover' => $uploadedFile,
        ], $id);

        $this->syncCategories($article, $categoriesIds);

        return $updated;
    }

    /**
     * @param int $id
     */
    public function destroyById(int $id)
    {
        $this->articleRepository->delete($id);
    }

    /**
     * @param UploadedFile|null $image
     * @param int $articleId
     * @return string|null
     */
    private function uploadImage(?UploadedFile $image, int $articleId): ?string
    {
        if ($image === null) {
            return null;
        }

        return $image->store(self::FILE_DIR.'/'.$articleId);
    }

    /**
     * @param Article $article
     * @param array $categoriesIds
     */
    private function syncCategories(Article &$article, array $categoriesIds = []): void
    {
        $article->categories()->sync($categoriesIds);
    }
}