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

        public function create()
    {
        return view('produk.tambah_produk');
    } 

        public function store(Request $request)
    {
        $produkData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        Produk::create($produkData);
    
        return redirect()->route('produk.melihat_produk')->with('success', 'Produk berhasil ditambahkan');
    }    
}
