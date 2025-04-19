<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Produk_Controller extends Controller
{
    // Menampilkan semua produk
    public function index()
    {
        $query = Produk::query();

        // Filter by category
        if (request()->has('kategori') && request('kategori') != '') {
            $query->where('kategori', request('kategori'));
        }

        // Filter by price range
        if (request()->has('harga') && request('harga') != '') {
            $priceRange = explode('-', request('harga'));
            $minPrice = $priceRange[0];
            $maxPrice = $priceRange[1];

            if ($maxPrice == '0') {
                // Untuk filter "Diatas X"
                $query->where('harga', '>=', $minPrice);
            } else {
                $query->whereBetween('harga', [$minPrice, $maxPrice]);
            }
        }

        // Filter by name
        if (request()->has('nama') && request('nama') != '') {
            $query->where('nama', 'like', '%' . request('nama') . '%');
        }

        $products = $query->get();
        $categories = Produk::distinct()->pluck('kategori');

        // Jika request AJAX, return JSON
        if (request()->ajax()) {
            return response()->json([
                'products' => $products,
                'html' => view('admin.produk._product_table', compact('products'))->render()
            ]);
        }

        // Jika admin, tampilkan view admin
        if (request()->is('admin/*')) {
            return view('admin.produk.index', compact('products', 'categories'));
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

        // Konversi harga dari format dengan titik menjadi angka biasa
        $produkData['harga'] = (float) str_replace('.', '', $request->harga);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Upload gambar ke folder public/uploads/produk
            $file->move(public_path('uploads/produk'), $filename);
            
            // Simpan path relatif ke database
            $produkData['gambar'] = 'uploads/produk/' . $filename;
        }

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

        // Konversi harga dari format dengan titik menjadi angka biasa
        $produkData['harga'] = (float) str_replace('.', '', $request->harga);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($product->gambar && file_exists(public_path($product->gambar))) {
                unlink(public_path($product->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Upload gambar ke folder public/uploads/produk
            $file->move(public_path('uploads/produk'), $filename);
            
            // Simpan path relatif ke database
            $produkData['gambar'] = 'uploads/produk/' . $filename;
        }

        $product->update($produkData);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    /**
     * Menghapus produk
     */
    public function destroy(Produk $product)
    {
        // Hapus gambar jika ada
        if ($product->gambar && file_exists(public_path($product->gambar))) {
            unlink(public_path($product->gambar));
        }

        // Hapus produk dari database
        $product->delete();

        return redirect()->route('admin.produk.index')
            ->with('success', 'Produk berhasil dihapus');
    }
}
