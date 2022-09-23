<?php

namespace App\Contracts;

use Request;

interface OrderContract
{
    public function storeOrderDetails($params);
}
