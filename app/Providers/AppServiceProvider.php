<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Category;
use App\Repositories\ArticleRepository;
use App\Repositories\ContactMessageRepository;
use App\Services\ArticleService;
use App\Services\ContactService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void {
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void {
        $categories = collect();
        if (Schema::hasTable('categories')) {
            $categories = Category::query()->get();
        }

        View::share('categories', $categories);
    }

    /**
     * Singleton Services class
     */
    private function registerServices(): void {
        $this->app->singleton(ArticleService::class);
        $this->app->singleton(ContactService::class);
    }

    /**
     * Singleton Repositories class
     */
    private function registerRepositories(): void {
        $this->app->singleton(ArticleRepository::class);
        $this->app->singleton(ContactMessageRepository::class);
    }
}
