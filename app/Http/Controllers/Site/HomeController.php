<?php

namespace App\Http\Controllers\Site;

use App\Contracts\AttributeContract;
use App\Contracts\CategoryContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\ProductRepository;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $productRepository;
    protected $categoryRepository;

    public function __construct(ProductContract $productRepository, CategoryContract $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function show()
    {
        $products = $this->productRepository->listProducts();
        $categories = $this->categoryRepository->listCategories();
        $featured = $this->productRepository->findProductByFeatured();

        return view('site.pages.homepage', compact('products', 'categories', 'featured'));
    }

    public function descPrice()
    {
        // $descPrice = $this->productRepository->filterProductByDescPrice();

        $descPrice = Product::orderBy('price', 'desc')->get();

        return view('site.pages.descprice', compact('descPrice'));
    }

    public function ascPrice()
    {
        // $ascPrice = $this->productRepository->filterProductByAscPrice();

        $ascPrice = Product::orderBy('price', 'asc')->get();

        return view('site.pages.ascprice', compact('ascPrice'));
    }
}
