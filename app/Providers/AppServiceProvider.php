<?php

declare(strict_types = 1);

namespace App\Providers;

use App\Category;
use App\Repositories\ContactMessageRepository;
use App\Services\ContactService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerRepositories();
        $this->registerServices();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        View::share('categories', Category::query()->get());
    }

    /**
     * Singleton Services class
     */
    private function registerServices(): void
    {
        $this->app->singleton(ContactService::class);
    }

    /**
     * Singleton Repositories class
     */
    private function registerRepositories(): void
    {
        $this->app->singleton(ContactMessageRepository::class);
    }
}
