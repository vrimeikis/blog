<?php

declare(strict_types = 1);

namespace App\DTO;

use App\Article;

/**
 * Class ArticleDTO
 * @package App\DTO
 */
class ArticleDTO extends BaseDTO
{
    /**
     * @var Article
     */
    private $article;

    /**
     * ArticleDTO constructor.
     * @param Article $article
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }


    /**
     * @return array
     */
    protected function jsonData(): array
    {
        return [
            'title' => $this->article->title,
            'slug' => $this->article->slug,
            'cover' => $this->article->cover,
            'content' => $this->article->content,
            'categories' => $this->categoriesDtoCollection(),
        ];
    }

    /**
     * @return CollectionDTO
     */
    private function categoriesDtoCollection(): CollectionDTO
    {
        $categoriesDTO = new CollectionDTO();

        if ($this->article->categories === null) {
            return $categoriesDTO;
        }

        foreach ($this->article->categories as $category) {
            $categoriesDTO->pushItem(new CategoryDTO($category));
        }

        return $categoriesDTO;
    }
}