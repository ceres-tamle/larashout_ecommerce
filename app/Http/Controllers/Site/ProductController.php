<?php

namespace App\Http\Controllers\Site;

use App\Contracts\ProductContract;
use App\Contracts\AttributeContract;
use App\Http\Controllers\Controller;
use App\Models\CartItems;
use App\Repositories\CartRepository;
use Auth;
use Illuminate\Http\Request;
use Cart;

class ProductController extends Controller
{
    protected $productRepository;
    protected $attributeRepository;
    protected $cartRepository;

    public function __construct(ProductContract $productRepository, AttributeContract $attributeRepository, CartRepository $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->attributeRepository = $attributeRepository;
        $this->cartRepository = $cartRepository;
    }

    public function show($slug)
    {
        $product = $this->productRepository->findProductBySlug($slug);
        $attributes = $this->attributeRepository->listAttributes();
        return view('site.pages.product', compact('product', 'attributes'));
    }

    public function variantPrice(Request $request)
    {
        $product = $this->productRepository->findProductById($request->idd);

        // take value when user select option
        $ca_val = $request->input('capacity');
        $ma_val = $request->input('materials');
        $co_val = $request->input('color');
        $si_val = $request->input('size');

        // product attributes price's
        $total_unit_price = $this->productRepository->productAttributesPrice($product, $ca_val, $ma_val, $co_val, $si_val);

        return number_format($total_unit_price, 2);
        // return $request->all();
        // return [];
    }

    // SESSION
    // handle price, quantity to display in cart
    public function addToCartBySession(Request $request)
    {
        $product = $this->productRepository->findProductById($request->input('productId'));
        $options = $request->except('_token', 'productId', 'price', 'qty');

        // take value when user select option
        $ca_val = $request->input('capacity');
        $ma_val = $request->input('materials');
        $co_val = $request->input('color');
        $si_val = $request->input('size');
        $qty_val = $request->input('qty');

        // product attributes id
        $product_id = $this->productRepository
            ->concatenateAllAttributes($request, $product, $ca_val, $ma_val, $co_val, $si_val);
        dd($product_id);

        // product attributes price's
        $total_unit_price = $this->productRepository->productAttributesPrice($product, $ca_val, $ma_val, $co_val, $si_val);

        // add product to cart
        Cart::add(
            $product_id,
            $product->name,
            $total_unit_price,
            $qty_val,
            $options,
        );

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    // DATABASE
    // handle price, quantity to display in cart
    public function addToCartByDB(Request $request)
    {
        $this->cartRepository->clearCouponSession(); // clear session coupon

        $product = $this->productRepository->findProductById($request->input('productId'));

        // take value when user select option
        $ca_val = $request->input('capacity');
        $ma_val = $request->input('materials');
        $co_val = $request->input('color');
        $si_val = $request->input('size');
        $qty_val = $request->input('qty');

        // product attributes id
        $product_id = $this->productRepository
            ->concatenateAllAttributes($request, $product, $ca_val, $ma_val, $co_val, $si_val);

        // product attributes price's
        $total_unit_price = $this->productRepository->productAttributesPrice($product, $ca_val, $ma_val, $co_val, $si_val);

        $cart_item = CartItems::where('product_id', $product_id)->count();
        if ($cart_item > 0) { // update product quantity in cart
            $item = CartItems::where('product_id', $product_id)->first();
            $item->quantity = $item->quantity + $qty_val;
            $item->grand_total = $item->grand_total + ($total_unit_price * $qty_val);
            $item->save();
        } elseif ($cart_item === 0) { // add new product to cart
            CartItems::create([
                'product_id' => $product_id,
                'name' => $product->name,
                'capacity' => $ca_val,
                'color' => $co_val,
                'materials' => $ma_val,
                'size' => $si_val,
                'quantity' => $qty_val,
                'price' => $total_unit_price,
                'discount' => 0,
                'grand_total' => ($total_unit_price * $qty_val),
                'user_id' => Auth::id(),
            ]);
        }

        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }
}
