<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'judul' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'isi' => 'required|string|min:50',
            'tanggal_publikasi' => 'required|date|before_or_equal:today',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

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
            'judul' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
            'isi' => 'required|string|min:50',
            'tanggal_publikasi' => 'required|date|before_or_equal:today',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($artikel->gambar && file_exists(public_path($artikel->gambar))) {
                unlink(public_path($artikel->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // Upload gambar ke folder public/uploads/artikel
            $file->move(public_path('uploads/artikel'), $filename);

            // Simpan path relatif ke database
            $artikelData['gambar'] = 'uploads/artikel/' . $filename;
        }

        // Sanitize HTML content
        $artikelData['isi'] = strip_tags($artikelData['isi'], '<p><br><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><u><blockquote><img><a>');

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
