<?php

namespace App\Contracts;

interface CartContract
{
    public function storeCartDetails();

    public function updateCartDetails();
}
