<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Ulasan;

class UserPesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('user_id', auth()->id())
            ->with(['produk', 'pengrajin'])
            ->latest()
            ->get();
        return view('user.pesanan.index', compact('pesanan'));
    }

    public function show($id)
    {
        $userId = Auth::id();
        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('user_id', $userId)
            ->with(['produk', 'pengrajin'])
            ->firstOrFail();


        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('user_id', $userId)
            ->firstOrFail();


        return view('user.pesanan.show', compact('pesanan'));
    }


    public function selesai($id)
    {
        $userId = Auth::id();
        $pesanan = Pesanan::where('id_pesanan', $id)
            ->where('user_id', $userId)
            ->where('status', 'Dikirim')
            ->firstOrFail();

        $pesanan->markAsCompleted();

        return redirect()->route('user.pesanan.index')
            ->with('success', 'Pesanan telah dikonfirmasi diterima.');
    }
    public function konfirmasiTerima($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->status = 'selesai';
        $pesanan->save();
        return redirect()->back()->with('success', 'Pesanan telah dikonfirmasi diterima.');
    }

    public function simpanUlasan(Request $request, $id)
    {
        $request->validate(['ulasan' => 'required']);
        $pesanan = Pesanan::findOrFail($id);
        Ulasan::create([
            'id_pesanan' => $pesanan->id_pesanan,
            'id_user' => auth()->id(),
            'ulasan' => $request->ulasan,
        ]);
        $pesanan->sudah_ulasan = 1;
        $pesanan->save();
        return redirect()->back()->with('success', 'Ulasan berhasil dikirim.');
    }
    public function paymentSuccess(Request $request)
    {
        $pesanan = Pesanan::where('order_id', $request->order_id)->firstOrFail();

        $pesanan->meta = [
            'alamat' => $request->alamat,
            'items' => $request->items, 
            'subtotal' => $request->subtotal,
            'ongkir' => $request->ongkir,
            'total' => $request->total,
        ];
        $pesanan->save();

    }
}
