<?php

namespace App\Services;

use App\Models\Cart;
use Auth;
use Darryldecode\Cart\CartCollection;

class CartStorage
{
    // Session
    public function has($key)
    {
        return Cart::find($key);
    }

    public function get($key)
    {
        if ($this->has($key)) {
            return new CartCollection(Cart::find($key)->cart_data);
        } else {
            return [];
        }
    }

    public function put($key, $value)
    {
        if ($row = Cart::find($key)) {
            // update
            $row->cart_data = $value;
            $row->save();
        } else {
            Cart::create([
                'id' => $key,
                'cart_data' => $value,
                'user_id' => Auth::id(),
            ]);
        }
    }
    
    // Database
}
