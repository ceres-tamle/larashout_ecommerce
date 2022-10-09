<?php

namespace App\Http\Controllers\Site;

use App\Contracts\CartContract;
use App\Contracts\ProductContract;
use App\Http\Controllers\Controller;
use App\Models\CartItems;
use Auth;
use Cart;

class CartController extends Controller
{
    protected $productRepository;
    protected $cartRepository;

    public function __construct(ProductContract $productRepository, CartContract $cartRepository)
    {
        $this->productRepository = $productRepository;
        $this->cartRepository = $cartRepository;
    }

    public function getCart()
    {
        $cart_items = CartItems::all()->where('user_id', Auth::id());
        $sum_cart = CartItems::where('user_id', Auth::id())->sum('grand_total');
        return view('site.pages.cart', compact('cart_items', 'sum_cart'));
    }

    // Removing Item from Shopping Cart
    public function removeSessionCart($id)
    {
        Cart::remove($id);
        $this->cartRepository->clearCouponSession();
        if (Cart::isEmpty()) {
            return redirect('/');
        }
        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }

    // Clearing Shopping Cart
    public function clearSessionCart()
    {
        Cart::clear();
        $this->cartRepository->clearCouponSession();
        return redirect('/');
    }

    public function removeCartInDB($id)
    {
        CartItems::find($id)->delete();
        $this->cartRepository->clearCouponSession();
        return redirect()->back()->with('message', 'Item removed from cart successfully.');
    }

    public function clearCartInDB()
    {
        CartItems::where('user_id', Auth::id())->delete();
        $this->cartRepository->clearCouponSession();
        return redirect('/');
    }
}
