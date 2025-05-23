<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        // Order by ID to maintain consistent ordering
        $query->orderBy('id', 'asc');
        
        $products = $query->paginate(10);
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
        return view('admin.produk.show', compact('products'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        if (request()->is('admin/*')) {
            return view('admin.produk.create');
        }
        return view('produk.tambah_produk');
    }

    /**
     * Display the specified product.
     */
    public function show(Produk $product)
    {
        return view('admin.produk.show', compact('product'));
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $produkData = $request->validate([
            'nama' => 'required|string|max:255',
            'harga_dasar' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'ukuran' => 'required|array',
            'ukuran.*' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Konversi harga dasar dari format dengan titik menjadi angka biasa
        $produkData['harga_dasar'] = (float) str_replace('.', '', $request->harga_dasar);
        
        // Konversi array ukuran menjadi string yang dipisahkan koma
        $produkData['ukuran'] = implode(',', $request->ukuran);

        // Hitung harga berdasarkan ukuran
        $ukuranTerpilih = $request->ukuran;
        $hargaDasar = $produkData['harga_dasar'];
        $hargaTotal = 0;

        foreach ($ukuranTerpilih as $ukuran) {
            if ($request->kategori === 'Merchandise') {
                // Untuk Merchandise, harga bertambah 50% untuk setiap peningkatan ukuran
                $ukuranCm = (int) explode(' x ', $ukuran)[0];
                $multiplier = $ukuranCm / 5; // 5 cm adalah ukuran terkecil
                $hargaTotal += $hargaDasar * $multiplier;
            } else {
                // Untuk Dekorasi, harga bertambah 100% untuk setiap meter
                $ukuranMeter = (int) explode(' ', $ukuran)[0];
                $hargaTotal += $hargaDasar * $ukuranMeter;
            }
        }

        $produkData['harga'] = $hargaTotal;

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
            'harga_dasar' => 'required|numeric|min:0',
            'kategori' => 'required|string|max:100',
            'ukuran' => 'required|array',
            'ukuran.*' => 'required|string',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Konversi harga dasar dari format dengan titik menjadi angka biasa
        $produkData['harga_dasar'] = (float) str_replace('.', '', $request->harga_dasar);
        
        // Konversi array ukuran menjadi string yang dipisahkan koma
        $produkData['ukuran'] = implode(',', $request->ukuran);

        // Hitung harga berdasarkan ukuran
        $ukuranTerpilih = $request->ukuran;
        $hargaDasar = $produkData['harga_dasar'];
        $hargaTotal = 0;

        foreach ($ukuranTerpilih as $ukuran) {
            if ($request->kategori === 'Merchandise') {
                // Untuk Merchandise, harga bertambah 50% untuk setiap peningkatan ukuran
                $ukuranCm = (int) explode(' x ', $ukuran)[0];
                $multiplier = $ukuranCm / 5; // 5 cm adalah ukuran terkecil
                $hargaTotal += $hargaDasar * $multiplier;
            } else {
                // Untuk Dekorasi, harga bertambah 100% untuk setiap meter
                $ukuranMeter = (int) explode(' ', $ukuran)[0];
                $hargaTotal += $hargaDasar * $ukuranMeter;
            }
        }

        $produkData['harga'] = $hargaTotal;

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

    // Menghapus produk
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
