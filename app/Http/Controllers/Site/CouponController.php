<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Session;
use Cart;

class CouponController extends Controller
{
    public function checkCoupon(Request $request)
    {
        $coupon_code = $request->input('coupon_code');
        Session::put('code', $coupon_code); // use this session in blade

        $coupon = Coupon::where('code', $coupon_code)
            ->where('active', 1)
            ->first();

        if ($coupon) { // if database has coupon code
            if (($coupon->count()) > 0) {
                $coupon_session = Session::get('coupon_code'); // create session
                if ($coupon_session == true) {
                    $is_avaiable = 0;
                    if ($is_avaiable == 0) {
                        $cou[] = array(
                            'code' => $coupon->code,
                            'condition' => $coupon->condition,
                            'discount' => $coupon->discount,
                        );
                    }
                } else {
                    $cou[] = array(
                        'code' => $coupon->code,
                        'condition' => $coupon->condition,
                        'discount' => $coupon->discount,
                    ); // dd($cou);
                    Session::put('coupon_code', $cou);

                    foreach (Session::get('coupon_code') as $key => $coupon) {
                        // DISCOUNT
                        if (Session::get('coupon_code') !== null) {
                            if (isset($coupon['condition'])  && $coupon['condition'] === 1) {
                                $discount = (Cart::getSubTotal() * $coupon['discount']) / 100;
                                // create session name 'discount_percent' with value $discount
                                Session::put('discount_percent', $discount);
                            } elseif (isset($coupon['condition']) && $coupon['condition'] === 2) {
                                // create session name 'discount_value' with value $coupon['discount']
                                Session::put('discount_value', $coupon['discount']);
                            }
                        }

                        // PAY
                        if (Session::get('coupon_code') !== null) {
                            if (isset($coupon['condition']) && $coupon['condition'] === 1) {
                                $pay = Cart::getSubTotal() - $discount;
                                // create session name 'pay_percent' with value $pay
                                Session::put('pay_percent', $pay);
                            } elseif (isset($coupon['condition']) && $coupon['condition'] === 2) {
                                $pay = Cart::getSubTotal() - $coupon['discount'];
                                // create session name 'pay_value' with value $pay
                                Session::put('pay_value', $pay);
                            }
                        }
                    }
                }
                Session::save();
                return redirect()->back()->with('message', 'Coupon has been applied successfully!');
            }
        } else { // if database has not coupon code
            return redirect()->back()->with('error', 'Apply coupon unsuccessfully!');
        }
    }

    public function cancelCoupon(Request $request)
    {
        $request->session()->forget('coupon_code');
        $request->session()->forget('discount_percent');
        $request->session()->forget('discount_value');
        $request->session()->forget('pay_percent');
        $request->session()->forget('pay_value');

        return redirect('/cart');
    }
}
