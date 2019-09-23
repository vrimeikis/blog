<?php

namespace App\Providers;

use App\Category;
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
}
