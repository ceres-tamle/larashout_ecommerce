<?php

namespace App\Repositories;

use App\Contracts\CartContract;
use App\Models\CartItems;

class CartRepository implements CartContract
{
    public function storeCartDetails()
    {
        CartItems::create([]);
    }

    public function updateCartDetails()
    {
    }
}
