<?php

namespace App\Http\Controllers\Site;

use App\Contracts\OrderContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutFormRequest;
use App\Models\Coupon;
use Cart;
use Session;

class CheckoutController extends Controller
{
    protected $orderRepository;

    public function __construct(OrderContract $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getCheckout()
    {
        return view('site.pages.checkout');
    }

    public function placeOrder(CheckoutFormRequest $request)
    {
        $this->orderRepository->storeOrderDetails($request->all());

        // Update active
        $coupon_code = Session::get('code');

        $time_coupon = Coupon::select('time')->where('code', $coupon_code)->first();
        $time_coupon = Coupon::select('time')->where('code', $coupon_code)->first();
        Session::put('time_coupon', $time_coupon);
        // dd(Session::get('time_coupon'));

        $time_coupon = Session::get('time_coupon');
        // dd(Session::get('time_coupon'));

        if (isset($time_coupon)) {
            if ((bool)$time_coupon == 1) { // if coupon time = 1

                $active = Coupon::select('id')->where('code', $coupon_code)->first();
                // dd($id);

                // $active = Coupon::findOrFail($id);
                // dd($active);
                if ($active) {
                    $active->active = 0;
                    $active->save();
                }
            } else {
                return 'Session error!';
            }
        }

        Cart::clear();

        // Session::forget('coupon_code');
        $request->session()->forget('coupon_code');
        $request->session()->forget('discount_percent');
        $request->session()->forget('discount_value');
        $request->session()->forget('pay_percent');
        $request->session()->forget('pay_value');

        return redirect('/');
    }
}
