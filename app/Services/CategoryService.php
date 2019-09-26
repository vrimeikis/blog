<?php

declare(strict_types = 1);

namespace App\Services;

use App\DTO\CategoryDTO;
use App\Repositories\CategoryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Class CategoryService
 * @package App\Services
 */
class CategoryService
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * CategoryService constructor.
     * @param CategoryRepository $categoryRepository
     */
    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginateData(): LengthAwarePaginator
    {
        return $this->categoryRepository->paginate();
    }

    /**
     * @param string $slug
     * @return CategoryDTO
     */
    public function getBySlugDTO(string $slug): CategoryDTO
    {
        $category = $this->categoryRepository->getBySlug($slug);

        $categoryDTO = new CategoryDTO($category);

        return $categoryDTO;
    }
}