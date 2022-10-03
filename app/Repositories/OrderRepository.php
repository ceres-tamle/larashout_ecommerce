<?php

namespace App\Repositories;

use App\Contracts\OrderContract;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetails;
use Cart;
use Session;

class OrderRepository extends BaseRepository implements OrderContract
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
        $this->model = $model;
    }

    public function storeOrderDetails($params)
    {
        if (Session::get('pay_percent') !== null) {
            $grand_total = Session::get('pay_percent');
        } elseif (Session::get('pay_value') !== null) {
            $grand_total = Session::get('pay_value');
        } else {
            $grand_total = Cart::getSubTotal();
        }

        $order = Order::create([
            'order_number'      =>  'ORD-' . strtoupper(uniqid()),
            'user_id'           =>  auth()->user()->id,
            'status'            =>  'processing',
            'total'             =>  Cart::getSubTotal(),
            'discount'          =>  Cart::getSubTotal() - $grand_total,
            'grand_total'       =>  $grand_total,
            'item_count'        =>  Cart::getTotalQuantity(),
            'payment_status'    =>  0,
            'payment_method'    =>  'COD',
            'first_name'        =>  $params['first_name'],
            'last_name'         =>  $params['last_name'],
            'address'           =>  $params['address'],
            'city'              =>  $params['city'],
            'country'           =>  $params['country'],
            'post_code'         =>  $params['post_code'],
            'phone_number'      =>  $params['phone_number'],
            'notes'             =>  $params['notes']
        ]);

        if ($order) {
            $items = Cart::getContent();

            foreach ($items as $item) {
                // A better way will be to bring the product id with the cart items
                // you can explore the package documentation to send product id with the cart
                $product = Product::where('name', $item->name)->first();

                // $orderItem = new OrderItem([
                //     'product_id'    => $product->id,
                //     'quantity'      => $item->quantity,
                //     'price'         => $item->getPriceSum(),
                // ]);
                // $order->items()->save($orderItem);

                $orderDetails = new OrderDetails([
                    'product_id'    => $product->id,
                    'quantity'      => $item->quantity,
                    'price'         => $item->getPriceSum(),
                    'capacity'      => $item->attributes->capacity,
                    'color'         => $item->attributes->color,
                    'materials'     => $item->attributes->materials,
                    'size'          => $item->attributes->size,
                ]);
                // dd($order->items());
                $order->items()->save($orderDetails);
            }
        }
        return $order;
    }
}
