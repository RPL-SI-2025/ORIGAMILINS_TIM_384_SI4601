<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class Produk_Controller extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $products = Produk::all();

        // Jika admin, tampilkan view admin
        if (request()->is('admin/*')) {
            return view('admin.produk.index', compact('products'));
        }

        // Jika user biasa
        return view('produk.melihat_produk', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        if (request()->is('admin/*')) {
            return view('admin.produk.create');
        }
        return view('produk.tambah_produk');
    }

    // Menyimpan produk baru
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

        if (request()->is('admin/*')) {
            return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
        }

        return redirect()->route('produk.melihat_produk')->with('success', 'Produk berhasil ditambahkan');
    }

    // Menampilkan form edit 
    public function edit(Produk $product)
    {
        return view('admin.produk.edit', compact('product'));
    }

    // Mengupdate produk
    public function update(Request $request, Produk $product)
    {
        $produkData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product->update($produkData);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }
}
