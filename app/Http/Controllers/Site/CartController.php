<?php

namespace App\Http\Controllers\Site;

use App\Contracts\CartContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use App\Models\CartItems;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    protected $productRepository;

    public function __construct(ProductContract $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function getCart()
    {
        $cart_items = CartItems::all();
        $sum_cart = CartItems::sum('grand_total');
        return view('site.pages.cart', compact('cart_items', 'sum_cart'));
    }

    // Removing Item from Shopping Cart
    public function removeSession($id)
    {
        Cart::remove($id);

        if (Cart::isEmpty()) {
            return redirect('/');
        }
        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }

    // Clearing Shopping Cart
    public function clearSession(Request $request)
    {
        Cart::clear();

        // Session::forget('coupon_code');
        $request->session()->forget('coupon_code');
        $request->session()->forget('discount_percent');
        $request->session()->forget('discount_value');
        $request->session()->forget('pay_percent');
        $request->session()->forget('pay_value');

        return redirect('/');
    }

    public function removeDataInDB($id)
    {
        CartItems::find($id)->delete();
        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }

    public function clearDataInDB()
    {
        CartItems::truncate();
        return redirect('/');
    }
}
