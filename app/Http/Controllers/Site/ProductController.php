<?php

namespace App\Http\Controllers\Site;

use App\Contracts\ProductContract;
use App\Contracts\AttributeContract;
use App\Http\Controllers\Controller;
use App\Models\ProductAttribute;
use Illuminate\Http\Request;
use Cart;
use Session;

class ProductController extends Controller
{
    protected $productRepository;
    protected $attributeRepository;

    public function __construct(ProductContract $productRepository, AttributeContract $attributeRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
    }

    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);
        Session::put('product_id', $product->id);
        Session::put('sale_price', $product->sale_price);
        Session::put('price', $product->price);
        // dd(Session::get('sale_price'));
        $attributes = $this->attributeRepository->listAttributes();
        return view('site.pages.product', compact('product', 'attributes'));
    }

    public function addToCart(Request $request)
    {
        $product = $this->productRepository->findProductById($request->input('productId'));
        $options = $request->except('_token', 'productId', 'price', 'qty');

        Cart::add(uniqid(), $product->name, $request->input('price'), $request->input('qty'), $options);

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    public function variantPrice(Request $request)
    {
        $product_id = Session::get('product_id');

        $price = Session::get('price');

        $sale_price = Session::get('sale_price');

        // take value when user select option
        $capacity_value = $request->input('capacity');
        $materials_value = $request->input('materials');
        $color_value = $request->input('color');
        $size_value = $request->input('size');

        // attributes price's product
        $capacity_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $capacity_value)->first();
        Session::put('capacity_price', $capacity_price);

        $materials_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $materials_value)->first();
        Session::put('materials_price', $materials_price);

        $color_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $color_value)->first();
        Session::put('color_price', $color_price);

        $size_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $size_value)->first();
        Session::put('size_price', $size_price);

        // var_dump($capacity_price);
        // var_dump($materials_price);
        // var_dump($color_price);
        // var_dump($size_price);

        // var_dump($capacity_price->price);
        // var_dump($materials_price->price);
        // var_dump($color_price->price);
        // var_dump($size_price->price);
        // die;

        // if $capacity_price->price null -> set $capacity_price->price = 0
        // $total_price = $price
        //     + ($capacity_price ? $capacity_price->price : 0)
        //     + ($materials_price ? $materials_price->price : 0)
        //     + ($color_price ? $color_price->price : 0)
        //     + ($size_price ? $size_price->price : 0);

        // Session::put('total_price', $total_price);

        if ($sale_price !== null) {
            $total_price = $sale_price
                + ($capacity_price ? $capacity_price->price : 0)
                + ($materials_price ? $materials_price->price : 0)
                + ($color_price ? $color_price->price : 0)
                + ($size_price ? $size_price->price : 0);
            Session::put('total_price', $total_price);
        } else {
            $total_price = $price
                + ($capacity_price ? $capacity_price->price : 0)
                + ($materials_price ? $materials_price->price : 0)
                + ($color_price ? $color_price->price : 0)
                + ($size_price ? $size_price->price : 0);
            Session::put('total_price', $total_price);
        }

        // var_dump(Session::get('total_price'));
        // var_dump($total_price);
        // die;

        return number_format($total_price, 2);
        // return $request->all();
        // return [];
    }
}
