<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function carts()
    {
        return $this->belongsToMany(Cart::class)->withPivot(['price', 'quantity', 'active']);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class)->withPivot(['price', 'quantity']);
    }

    public function getTotalOrder()
    {
        $order_products = OrderProduct::where('product_id', $this->id)->get();
        $total = 0;
        foreach ($order_products as $order_product) {
            $total += $order_product->quantity;
        }
        return $total;
    }

    public function getTotalRevenue()
    {
        $order_products = OrderProduct::where('product_id', $this->id)->get();
        $total = 0;
        foreach ($order_products as $order_product) {
            $total += $order_product->price;
        }
        return $total;
    }
}
