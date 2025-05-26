<?php

namespace App\Traits;

use App\Models\Cart;

trait HasCart
{
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function getOrCreateCart()
    {
        $cart = $this->cart()->first();
        if (!$cart) {
            $cart = $this->cart()->create([
                'total' => 0
            ]);
        }
        return $cart;
    }
} 