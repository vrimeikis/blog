<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Article;
use App\Repositories\Abstracts\Repository;

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
}