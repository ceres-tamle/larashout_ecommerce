<?php

namespace App\Repositories;

use App\Contracts\CartContract;
use Session;

class CartRepository implements CartContract
{
    public function clearCouponSession()
    {
        Session::forget('coupon_code');
        Session::forget('type');
        Session::forget('discount');
        Session::forget('pay');
    }
}
