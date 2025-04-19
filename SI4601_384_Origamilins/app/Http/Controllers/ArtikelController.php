<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::latest()->get();
        return view('admin.artikel.index', compact('artikels'));
    }

    public function create()
    {
        return view('admin.artikel.create');
    }

    public function store(Request $request)
    {
        $artikelData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'gambar' => 'required'
        ]);

        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Upload gambar ke folder public/uploads/artikel
            $file->move(public_path('uploads/artikel'), $filename);
            
            // Simpan path relatif ke database
            $artikelData['gambar'] = 'uploads/artikel/' . $filename;
        }

        Artikel::create($artikelData);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil ditambahkan!');
    }

    public function show($id_artikel)
    {
        $artikel = Artikel::findOrFail($id_artikel);
        return view('admin.artikel.show', compact('artikel'));
    }

    public function edit($id_artikel)
    {
        $artikel = Artikel::findOrFail($id_artikel);
        return view('admin.artikel.edit', compact('artikel'));
    }

    public function update(Request $request, $id_artikel)
    {
        $artikel = Artikel::findOrFail($id_artikel);
        
        $artikelData = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'tanggal_publikasi' => 'required|date',
            'gambar' => 'required'
        ]);

        if ($request->hasFile('gambar')) {
            $request->validate([
                'gambar' => 'image|mimes:jpeg,png,jpg|max:2048'
            ]);
            
            // Hapus gambar lama jika ada
            if ($artikel->gambar && file_exists(public_path($artikel->gambar))) {
                unlink(public_path($artikel->gambar));
            }
            
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            // Upload gambar ke folder public/uploads/artikel
            $file->move(public_path('uploads/artikel'), $filename);
            
            // Simpan path relatif ke database
            $artikelData['gambar'] = 'uploads/artikel/' . $filename;
        }

        $artikel->update($artikelData);

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy($id_artikel)
    {
        $artikel = Artikel::findOrFail($id_artikel);
        
        // Hapus gambar jika ada
        if ($artikel->gambar && file_exists(public_path($artikel->gambar))) {
            unlink(public_path($artikel->gambar));
        }
        
        $artikel->delete();

        return redirect()->route('admin.artikel.index')
            ->with('success', 'Artikel berhasil dihapus!');
    }
} 