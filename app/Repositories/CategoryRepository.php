<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Category;
use App\Repositories\Abstracts\Repository;

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
}