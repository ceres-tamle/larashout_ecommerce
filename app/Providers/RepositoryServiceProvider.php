<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AttributeContract;
use App\Contracts\BrandContract;
use App\Contracts\CategoryContract;
use App\Contracts\OrderContract;
use App\Contracts\ProductContract;
use App\Repositories\AttributeRepository;
use App\Repositories\BrandRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    // Binding Contract to Repository
    protected $repositories = [
        CategoryContract::class => CategoryRepository::class,
        AttributeContract::class => AttributeRepository::class,
        BrandContract::class => BrandRepository::class,
        ProductContract::class => ProductRepository::class,
        OrderContract::class => OrderRepository::class
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->repositories as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
