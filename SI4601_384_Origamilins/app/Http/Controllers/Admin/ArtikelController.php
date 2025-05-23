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
        try {
            $artikelData = $request->validate([
                'judul' => 'required|string|max:255|regex:/^[\pL\s\-]+$/u',
                'isi' => 'required|string|min:50',
                'tanggal_publikasi' => 'required|date',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            // Sanitize HTML content
            $artikelData['isi'] = strip_tags($artikelData['isi'], '<p><br><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><u><blockquote><img><a>');

            if ($request->hasFile('gambar')) {
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                
                // Pastikan direktori ada
                $uploadPath = public_path('uploads/artikel');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }

                // Upload gambar ke folder public/uploads/artikel
                $file->move($uploadPath, $filename);

                // Simpan path relatif ke database
                $artikelData['gambar'] = 'uploads/artikel/' . $filename;
            }

            Artikel::create($artikelData);

            return redirect()->route('admin.artikel.index')
                ->with('success', 'Artikel berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
        try {
            $artikel = Artikel::findOrFail($id_artikel);
    
            $request->validate([
                'judul' => 'required|string|max:255',
                'isi' => 'required|string|min:50',
                'tanggal_publikasi' => 'required|date',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ], [], [
                'judul' => 'Judul Artikel',
                'isi' => 'Isi Artikel',
                'tanggal_publikasi' => 'Tanggal Publikasi',
                'gambar' => 'Gambar Artikel',
            ]);
    
            $artikelData = $request->only(['judul', 'isi', 'tanggal_publikasi']);
    
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($artikel->gambar && file_exists(public_path($artikel->gambar))) {
                    unlink(public_path($artikel->gambar));
                }
    
                $file = $request->file('gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
    
                // Pastikan direktori ada
                $uploadPath = public_path('uploads/artikel');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
    
                // Upload gambar ke folder public/uploads/artikel
                $file->move($uploadPath, $filename);
    
                // Simpan path relatif ke database
                $artikelData['gambar'] = 'uploads/artikel/' . $filename;
            }
    
            // Sanitize HTML content
            $artikelData['isi'] = strip_tags($artikelData['isi'], '<p><br><h1><h2><h3><h4><h5><h6><ul><ol><li><strong><em><u><blockquote><img><a>');
    
            $artikel->update($artikelData);
    
            return redirect()->route('admin.artikel.index')->with('success', 'Artikel berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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
