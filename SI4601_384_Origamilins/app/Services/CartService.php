<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;

class CartService
{
    public function getOrCreateCart(User $user)
    {
        $cart = $user->cart()->first();
        if (!$cart) {
            $cart = $user->cart()->create([
                'total' => 0
            ]);
        }
        return $cart;
    }
} 