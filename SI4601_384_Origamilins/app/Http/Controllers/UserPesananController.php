<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('user_id', auth()->id())->latest()->get();
        return view('user.pesanan.index', compact('pesanan'));
    }

     public function show($id)
    {
        $userId = Auth::id();

$pesanan = Pesanan::where('id_pesanan', $id)
    ->where('user_id', $userId)
    ->firstOrFail();

$pesanan->is_read = true;
$pesanan->save();
        // Bisa passing ke view detail pesanan
        return view('user.pesanan.show', compact('pesanan'));
    }
}
