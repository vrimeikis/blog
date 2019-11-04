<?php

declare(strict_types = 1);

namespace App\Services\Grab;

use App\Repositories\ArticleRepository;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;

class ArticlesFromVRApiService
{
    const BASE_API_ROUTE = 'http://articles.vrwebdeveloper.lt/api';
    const API_VERSION = 'v1';

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * ArticlesFromVRApiService constructor.
     *
     * @param ArticleRepository $articleRepository
     */
    public function __construct(ArticleRepository $articleRepository) {
        $this->articleRepository = $articleRepository;
    }

    public function getArticles(?string $url = null): void {
        if ($url === null) {
            $url = $this->getArticleListEndpoint();
        }

        $dataArray = $this->getData($url);

        $articles = Arr::get($dataArray, 'data.data', []);
        if (count($articles) <= 0) {
            return;
        }

        foreach ($articles as $article) {
            $slug = Arr::get($article, 'slug');
            $exists = $this->articleRepository->existsBySlug($slug);
            if ($exists === true) {
                continue;
            }

            $this->articleRepository->create([
                'title' => Arr::get($article, 'title'),
                'slug' => $slug,
                'content' => Arr::get($article, 'content'),
            ]);
        }

        $nextPageUrl = Arr::get($dataArray, 'data.next_page_url');

        if ($nextPageUrl !== null){
            $this->getArticles($nextPageUrl);
        }

        return;
    }

    private function getData(string $url): array {
        $client = new Client();
        $response = $client->get($url);

        $data = $response->getBody()->getContents();
        $dataArray = json_decode($data, true);

        $success = Arr::get($dataArray, 'success');
        if ($success !== true) {
            return []; // todo: throw exception
        }

        return $dataArray;
    }

    private function getArticleListEndpoint(): string {
        return sprintf('%s/%s/%s', self::BASE_API_ROUTE, self::API_VERSION, 'article');
    }
}