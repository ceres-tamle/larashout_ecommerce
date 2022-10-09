<?php

namespace App\Http\Controllers\Site;

use App\Contracts\OrderContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutFormRequest;
use App\Models\CartItems;
use App\Models\Coupon;
use App\Repositories\CartRepository;
use Auth;
use Session;

class CheckoutController extends Controller
{
    protected $orderRepository;
    protected $cartRepository;

    public function __construct(OrderContract $orderRepository, CartRepository $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function getCheckout()
    {
        $sum_cart = CartItems::where('user_id', Auth::id())->sum('grand_total');
        return view('site.pages.checkout', compact('sum_cart'));
    }

    public function placeOrder(CheckoutFormRequest $request)
    {
        $this->orderRepository->storeOrderDetails($request->all());

        // Update active
        $coupon_code = Session::get('code'); // value from CouponController

        $coupon_time = Coupon::select('time')->where('code', $coupon_code)->first();

        if (isset($coupon_time->time) && $coupon_time->time === 1) { // if coupon time = 1

            $active = Coupon::select('id')->where('code', $coupon_code)->first();
            // $active = Coupon::findOrFail($id);
            // dd($active);

            if ($active) {
                $active->active = 0;
                $active->save();
            }
        }

        // Cart::clear();
        CartItems::where('user_id', Auth::id())->delete();

        $this->cartRepository->clearCouponSession();

        return redirect('/');
    }
}
