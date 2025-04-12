<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class Produk_Controller extends Controller
{
        public function index()
    {
        $products = Produk::all();
        return view('produk.melihat_produk', compact('products'));
    }


}
