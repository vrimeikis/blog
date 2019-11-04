<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Article;
use App\Repositories\Abstracts\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ArticleRepository
 * @package App\Repositories
 */
class ArticleRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Article::class;
    }

    /**
     * @param string $slug
     * @return Article|Model
     */
    public function findBySlug(string $slug): Article
    {
        return $this->makeQuery()->where('slug', '=', $slug)
            ->firstOrFail();
    }

    /**
     * @param string $slug
     *
     * @return bool
     */
    public function existsBySlug(string $slug): bool {
        return $this->makeQuery()->where('slug', '=', $slug)
            ->exists();
    }
}