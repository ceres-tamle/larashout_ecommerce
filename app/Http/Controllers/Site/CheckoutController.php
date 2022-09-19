<?php

namespace App\Http\Controllers\Site;

use App\Models\Order;
use App\Contracts\OrderContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\PayPalService;
use App\Http\Requests\CheckoutFormRequest;
use Cart;

class CheckoutController extends Controller
{
    protected $orderRepository;
    protected $payPal;

    public function __construct(OrderContract $orderRepository, PayPalService $payPal)
    {
        $this->orderRepository = $orderRepository;
        $this->payPal = $payPal;
    }

    public function getCheckout()
    {
        return view('site.pages.checkout');
    }

    public function placeOrder(CheckoutFormRequest $request)
    {
        $this->orderRepository->storeOrderDetails($request->all());

        Cart::clear();

        return redirect('/');
        // return redirect('/checkout/payment/complete');

        // Before storing the order we should implement the
        // request validation which I leave it to you
        // $order = $this->orderRepository->storeOrderDetails($request->all());
        // dd($order);

        // You can add more control here to handle if the order
        // is not stored properly
        // if ($order) {
        //     $this->payPal->processPayment($order);
        //     // dd($order);
        // }

        // return redirect()->back()->with('message', 'Order not placed');
    }

    // public function complete(Request $request)
    // {
    //     $paymentId = $request->input('paymentId');
    //     $payerId = $request->input('PayerID');

    //     $status = $this->payPal->completePayment($paymentId, $payerId);

    //     $order = Order::where('order_number', $status['invoiceId'])->first();
    //     $order->status = 'processing';
    //     $order->payment_status = 1;
    //     $order->payment_method = 'PayPal -' . $status['salesId'];
    //     $order->save();

    //     Cart::clear();
    //     return view('site.pages.success', compact('order'));
    // }
}
