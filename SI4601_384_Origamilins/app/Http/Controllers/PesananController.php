<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index']);
    }

    public function index()
    {
        $pesanan = Pesanan::latest()->get();
        return view('admin.pesananproduk.index', compact('pesanan'));
    }

    public function edit($id_pesanan)
    {
        try {
            $pesanan = Pesanan::findOrFail($id_pesanan);
            $statusOptions = Pesanan::getStatusOptions();
            return view('admin.pesananproduk.edit', compact('pesanan', 'statusOptions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pesananproduk.index')
                ->with('error', 'Pesanan produk tidak ditemukan');
        }
    }

    public function update(Request $request, $id_pesanan)
    {
        try {
            $request->validate([
                'status' => 'required|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan'
            ]);

            $pesanan = Pesanan::findOrFail($id_pesanan);
            $pesanan->update([
                'status' => $request->status
            ]);

            return redirect()->route('admin.pesananproduk.index')
                ->with('success', 'Status pesanan produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status pesanan produk: ' . $e->getMessage());
        }
    }
} 