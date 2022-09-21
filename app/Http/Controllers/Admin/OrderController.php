<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Redirect;

class OrderController extends Controller
{
    public function index()
    {
        // $users = User::all();
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    public function create()
    {
    }

    public function store()
    {
    }

    public function edit($id)
    {
        // Find an order
        $order = Order::find($id);
        // Find all order statuses
        $order_statuses = OrderStatus::all();
        return view('admin.orders.edit', compact('order', 'order_statuses'));
    }

    public function update(Request $request)
    {
        // Update orders.status by order_statuses.order_status
        $order = Order::where('id', $request->input('id'))->first();
        $order->status = $request->input('order_status');
        $order->save();

        return Redirect('/admin/orders');
    }

    public function delete($id)
    {
        $order = Order::find($id);

        $order->delete();

        return Redirect('/admin/orders');
    }
}
