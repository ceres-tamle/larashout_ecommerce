<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItems extends Model
{
    protected $table = 'cart_items';

    protected $fillable = [
        'product_id', 'name', 'capacity', 'color', 'materials', 'size', 'quantity', 'price', 'discount', 'grand_total', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
