<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'produk_id',
        'jumlah',
        'subtotal'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function produk()
    {
        return $this->belongsTo(\App\Models\Produk::class, 'produk_id');
    }

    public function updateSubtotal()
    {
        $this->subtotal = $this->produk->harga * $this->jumlah;
        $this->save();
        $this->cart->updateTotal();
    }
} 