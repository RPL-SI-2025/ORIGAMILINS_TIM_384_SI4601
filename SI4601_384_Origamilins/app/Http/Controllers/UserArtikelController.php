<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use Illuminate\Http\Request;

class UserArtikelController extends Controller
{
    public function index()
    {
        $artikels = Artikel::orderBy('tanggal_publikasi', 'desc')->get();
        return view('user.artikel.index', compact('artikels'));
    }

    public function show($id)
    {
        $artikel = Artikel::findOrFail($id);
        return view('user.artikel.show', compact('artikel'));
    }
}