<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    public function getCart()
    {
        return view('site.pages.cart');
    }

    // SUM product price with quantity, variant
    public function getProductPrice()
    {
    }

    // SUM total product price in cart
    public function getProductTotal()
    {
    }

    // Removing Item from Shopping Cart
    public function removeItem($id)
    {
        Cart::remove($id);

        if (Cart::isEmpty()) {
            return redirect('/');
        }
        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }

    // Clearing Shopping Cart
    public function clearCart(Request $request)
    {
        Cart::clear();

        // Session::forget('coupon_code');
        $request->session()->forget('coupon_code');
        $request->session()->forget('discount_percent');
        $request->session()->forget('discount_value');
        $request->session()->forget('pay_percent');
        $request->session()->forget('pay_value');
        $request->session()->forget('total_price');

        return redirect('/');
    }
}
