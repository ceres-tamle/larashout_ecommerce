<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupons.create');
    }

    public function store(Request $request)
    {
        Coupon::create([
            'name' => $request->input('name'),
            'code' => $request->input('code'),
            'time' => $request->input('time'),
            'condition' => $request->input('condition'),
            'number' => $request->input('number'),
        ]);

        return redirect('/admin/coupons');
    }

    public function delete($id)
    {
        $coupon = Coupon::find($id);

        $coupon->delete();

        return redirect('/admin/coupons');
    }
}
