<?php

namespace App\Http\Controllers\Site;

use App\Contracts\CartContract;
use App\Http\Controllers\Controller;
use App\Models\CartItems;
use App\Models\Coupon;
use Auth;
use Illuminate\Http\Request;
use Session;

class CouponController extends Controller
{
    protected $cartRepository;

    public function __construct(CartContract $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function checkCoupon(Request $request)
    {
        $coupon_code = $request->input('coupon_code');
        Session::put('code', $coupon_code); // use this session in CheckoutController to update active

        $coupon = Coupon::where('code', $coupon_code)
            ->where('active', 1)
            ->first();

        if ($coupon) { // if database has coupon code
            if (($coupon->count()) > 0) {
                $coupon_session = Session::get('coupon_code'); // create session
                if ($coupon_session == true) {
                    $is_avaiable = 0;
                    if ($is_avaiable == 0) {
                        $coupon_array[] = array(
                            'code' => $coupon->code,
                            'time' => $coupon->time,
                            'condition' => $coupon->condition,
                            'discount' => $coupon->discount,
                        );
                    }
                } else {
                    $coupon_array[] = array(
                        'code' => $coupon->code,
                        'time' => $coupon->time,
                        'condition' => $coupon->condition,
                        'discount' => $coupon->discount,
                    );

                    // SESSION
                    // foreach ($coupon_array as $key => $coupon) {
                    //     if ($coupon['code'] !== null) {

                    //         Session::put('coupon_code', $coupon['code']);

                    //         if (isset($coupon['condition']) && $coupon['condition'] === 1) { // if condition = percent

                    //             // COUPON PERCENT
                    //             Session::put('type', number_format($coupon['discount'], 2) . "%");

                    //             // DISCOUNT PERCENT
                    //             $discount = (Cart::getSubTotal() * $coupon['discount']) / 100;
                    //             Session::put('discount', $discount);

                    //             // PAY PERCENT
                    //             $pay = Cart::getSubTotal() - $discount;
                    //             Session::put('pay', $pay);
                    //         } elseif (isset($coupon['condition']) && $coupon['condition'] === 2) { // if condition = value

                    //             // COUPON VALUE
                    //             Session::put('type', number_format($coupon['discount'], 2)
                    //                 . config('settings.currency_symbol'));

                    //             // DISCOUNT VALUE
                    //             Session::put('discount', $coupon['discount']);

                    //             // PAY VALUE
                    //             $pay = Cart::getSubTotal() - $coupon['discount'];
                    //             Session::put('pay', $pay);
                    //         }
                    //     }
                    // }

                    // DATABASE
                    foreach ($coupon_array as $key => $coupon) {
                        if ($coupon['code'] !== null) {

                            $sum_cart = CartItems::where('user_id', Auth::id())->sum('grand_total');

                            Session::put('coupon_code', $coupon['code']);

                            if (isset($coupon['condition']) && $coupon['condition'] === 1) { // if condition = percent

                                // COUPON PERCENT
                                Session::put('type', number_format($coupon['discount'], 2) . "%");

                                // DISCOUNT PERCENT
                                $discount = ($sum_cart * $coupon['discount']) / 100;
                                Session::put('discount', $discount);

                                // PAY PERCENT
                                $pay = $sum_cart - $discount;
                                Session::put('pay', $pay);
                            } elseif (isset($coupon['condition']) && $coupon['condition'] === 2) { // if condition = value

                                // COUPON VALUE
                                Session::put('type', number_format($coupon['discount'], 2)
                                    . config('settings.currency_symbol'));

                                // DISCOUNT VALUE
                                Session::put('discount', $coupon['discount']);

                                // PAY VALUE
                                $pay = $sum_cart - $coupon['discount'];
                                Session::put('pay', $pay);
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

    public function cancelCoupon()
    {
        $this->cartRepository->clearCouponSession();
        return redirect('/cart');
    }
}
