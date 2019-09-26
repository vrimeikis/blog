<?php

declare(strict_types = 1);

namespace App\DTO;

use App\Article;

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
        ];
    }
}