<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Category;
use App\Repositories\Abstracts\Repository;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryRepository
 * @package App\Repositories
 */
class CategoryRepository extends Repository
{

    /**
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }

    /**
     * @param string $slug
     * @return Category|Model|null
     */
    public function getBySlug(string $slug): ?Category
    {
        return $this->makeQuery()->where('slug', '=', $slug)
            ->first();
    }
}