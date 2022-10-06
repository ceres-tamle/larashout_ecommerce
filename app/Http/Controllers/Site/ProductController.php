<?php

namespace App\Http\Controllers\Site;

use App\Contracts\ProductContract;
use App\Contracts\AttributeContract;
use App\Http\Controllers\Controller;
use App\Models\CartItems;
use App\Models\ProductAttribute;
use Auth;
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

        $attributes = $this->attributeRepository->listAttributes();
        return view('site.pages.product', compact('product', 'attributes'));
    }

    // SESSION
    // handle price, quantity to display in cart
    public function addToCartBySession(Request $request)
    {
        $user_id = Auth::id();
        $product = $this->productRepository->findProductById($request->input('productId'));
        $options = $request->except('_token', 'productId', 'price', 'qty');

        // take value when user select option
        $capacity_value = $request->input('capacity');
        $materials_value = $request->input('materials');
        $color_value = $request->input('color');
        $size_value = $request->input('size');

        // attributes price's product
        $capacity_price = ProductAttribute::select('price')
            ->where('product_id', $product->id)
            ->where('value', $capacity_value)->first();

        $materials_price = ProductAttribute::select('price')
            ->where('product_id', $product->id)
            ->where('value', $materials_value)->first();

        $color_price = ProductAttribute::select('price')
            ->where('product_id', $product->id)
            ->where('value', $color_value)->first();

        $size_price = ProductAttribute::select('price')
            ->where('product_id', $product->id)
            ->where('value', $size_value)->first();

        if ($capacity_value !== null || $materials_value !== null || $color_value !== null || $size_value !== null) { // if product has variant

            if ($product->sale_price !== null) { // if product has sale_price
                $total_unit_price = $product->sale_price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            } else { // if product has no sale_price
                $total_unit_price = $product->price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            }
        } elseif ($capacity_value === null && $materials_value === null && $color_value === null && $size_value === null) { // if product has no variant
            $total_unit_price = $product->sale_price != '' ? $product->sale_price : $product->price;
        }

        // product attributes id
        $capacity_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $capacity_value)->first();

        $materials_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $materials_value)->first();

        $color_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $color_value)->first();

        $size_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $size_value)->first();

        // set product id in cart
        if (isset($capacity_id->id)) {
            $capacity_idd = $capacity_id->id;
        } else {
            $capacity_idd = '00';
        }

        if (isset($materials_id->id)) {
            $materials_idd = $materials_id->id;
        } else {
            $materials_idd = '00';
        }

        if (isset($color_id->id)) {
            $color_idd = $color_id->id;
        } else {
            $color_idd = '00';
        }

        if (isset($size_id->id)) {
            $size_idd = $size_id->id;
        } else {
            $size_idd = '00';
        }

        if (isset($capacity_idd) || isset($materials_idd) || isset($color_idd) || isset($size_idd)) {
            $product_id = $product->id
                . ('-ca' . $capacity_idd)
                . ('-ma' . $materials_idd)
                . ('-co' . $color_idd)
                . ('-si' . $size_idd);
        } else {
            $product_id = $product->id . '-no';
        }

        // add product to cart
        // Cart::add(uniqid(), $product->name, $total_unit_price, $request->input('qty'), $options);
        Cart::add(
            $product_id,
            $product->name,
            $total_unit_price,
            $request->input('qty'),
            $options
        );

        // dd(Cart::getContent());

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    public function variantPrice(Request $request)
    {
        // value from SHOW function
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

        $materials_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $materials_value)->first();

        $color_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $color_value)->first();

        $size_price = ProductAttribute::select('price')
            ->where('product_id', $product_id)
            ->where('value', $size_value)->first();

        // var_dump($capacity_price->price);
        // var_dump($materials_price->price);
        // var_dump($color_price->price);
        // var_dump($size_price->price);
        // die;

        if ($capacity_value !== null || $materials_value !== null || $color_value !== null || $size_value !== null) { // if product has variant

            if ($sale_price !== null) { // if product has sale_price
                $total_unit_price = $sale_price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            } else { // if product has no sale_price
                $total_unit_price = $price
                    + ($capacity_price ? $capacity_price->price : 0)
                    + ($materials_price ? $materials_price->price : 0)
                    + ($color_price ? $color_price->price : 0)
                    + ($size_price ? $size_price->price : 0);
            }
        } elseif ($capacity_value === null && $materials_value === null && $color_value === null && $size_value === null) { // if product has no variant
        }

        return number_format($total_unit_price, 2);
        // return $request->all();
        // return [];
    }

    // DATABASE
    // handle price, quantity to display in cart
    public function addToCartByDB(Request $request)
    {
        $product = $this->productRepository->findProductById($request->input('productId'));

        // take value when user select option
        $capacity_value = $request->input('capacity');
        $materials_value = $request->input('materials');
        $color_value = $request->input('color');
        $size_value = $request->input('size');
        $quantity_value = $request->input('qty');

        // CAPACITY // product attributes id
        $capacity_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $capacity_value)->first();

        // set product id in cart
        if (isset($capacity_id->id)) {
            $capacity_idd = $capacity_id->id;
        } else {
            $capacity_idd = '00';
        }

        //MATERIALS
        $materials_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $materials_value)->first();

        if (isset($materials_id->id)) {
            $materials_idd = $materials_id->id;
        } else {
            $materials_idd = '00';
        }

        // COLOR
        $color_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $color_value)->first();

        if (isset($color_id->id)) {
            $color_idd = $color_id->id;
        } else {
            $color_idd = '00';
        }

        // SIZE
        $size_id = ProductAttribute::select('id')
            ->where('product_id', $product->id)
            ->where('value', $size_value)->first();

        if (isset($size_id->id)) {
            $size_idd = $size_id->id;
        } else {
            $size_idd = '00';
        }

        // product id concatenation
        if (isset($capacity_idd) || isset($materials_idd) || isset($color_idd) || isset($size_idd)) {
            $product_id = $product->id
                . ('-ca' . $capacity_idd)
                . ('-ma' . $materials_idd)
                . ('-co' . $color_idd)
                . ('-si' . $size_idd);
        } else {
            $product_id = $product->id . '-no';
        }

        $cart_item = CartItems::where('product_id', $product_id)->count();
        if ($cart_item > 0) { // update product quantity in cart
            $item = CartItems::where('product_id', $product_id)->first();
            $item->quantity = $item->quantity + 1;
            $item->save();
        } elseif ($cart_item === 0) { // add new product to cart
            CartItems::create([
                'product_id' => $product_id,
                'name' => $product->name,
                'capacity' => $capacity_value,
                'color' => $color_value,
                'materials' => $materials_value,
                'size' => $size_value,
                'quantity' => $quantity_value,
                'price' => $product->price,
                'discount' => 0,
                'grand_total' => $product->price * $quantity_value,
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }
}
