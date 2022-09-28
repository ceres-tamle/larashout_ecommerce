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
            'active' => $request->input('active'),
            'discount' => $request->input('discount'),
        ]);

        return redirect('/admin/coupons');
    }

    public function edit($id)
    {
        $coupon = Coupon::find($id);
        return view('admin.coupons.edit', ['coupon' => $coupon]);
    }

    public function update(Request $request)
    {
        $coupon = Coupon::where('id', $request->input('id'))->first();
        $coupon->name = $request->input('name');
        $coupon->code = $request->input('code');
        $coupon->time =  $request->input('time');
        $coupon->condition = $request->input('condition');
        $coupon->active = $request->input('active');
        $coupon->discount = $request->input('discount');
        $coupon->save();

        return redirect('/admin/coupons');
    }

    public function delete($id)
    {
        $coupon = Coupon::find($id);

        $coupon->delete();

        return redirect('/admin/coupons');
    }
}
