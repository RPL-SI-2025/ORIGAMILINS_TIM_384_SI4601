<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login');
        }

        $pesanan = Pesanan::orderBy('created_at', 'desc')->get();
        
        // Status options untuk dropdown
        $statusOptions = [
            'Menunggu' => 'Menunggu',
            'Dikonfirmasi' => 'Dikonfirmasi',
            'Selesai' => 'Selesai',
            'Dibatalkan' => 'Dibatalkan'
        ];
        
        // Ekspedisi options untuk dropdown
        $ekspedisiOptions = [
            'JNE' => 'JNE',
            'J&T' => 'J&T',
            'SiCepat' => 'SiCepat',
            'Pos Indonesia' => 'Pos Indonesia',
            'TIKI' => 'TIKI'
        ];

        return view('admin.pesananproduk.index', compact('pesanan', 'statusOptions', 'ekspedisiOptions'));
    }

    public function edit($id_pesanan)
    {
        try {
            if (!Auth::check() || Auth::user()->role !== 'admin') {
                return redirect('/login');
            }

            $pesanan = Pesanan::findOrFail($id_pesanan);
            $statusOptions = Pesanan::getStatusOptions();
            $ekspedisiOptions = Pesanan::getEkspedisiOptions();
            return view('admin.pesananproduk.edit', compact('pesanan', 'statusOptions', 'ekspedisiOptions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pesananproduk.index')
                ->with('error', 'Pesanan produk tidak ditemukan');
        }
    }

    public function update(Request $request, $id_pesanan)
    {
        try {
            if (!Auth::check() || Auth::user()->role !== 'admin') {
                return redirect('/login');
            }

            $request->validate([
                'status' => 'required|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan',
                'ekspedisi' => 'required|in:JNE,J&T,SiCepat,Pos Indonesia,TIKI'
            ]);

            $pesanan = Pesanan::findOrFail($id_pesanan);
            $pesanan->update([
                'status' => $request->status,
                'ekspedisi' => $request->ekspedisi
            ]);

            return redirect()->route('admin.pesananproduk.index')
                ->with('success', 'Status dan ekspedisi pesanan produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pesanan produk: ' . $e->getMessage());
        }
    }
}