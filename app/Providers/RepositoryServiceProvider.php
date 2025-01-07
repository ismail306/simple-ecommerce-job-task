<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use App\Interfaces\CartInterface;
use App\Repositories\CartRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CartInterface::class, CartRepository::class);
    }
}
