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

    public function index(Request $request)
    {
        $query = Pesanan::query();

        // Search with partial word matching
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('nama_produk', 'like', "%{$search}%")
                  ->orWhere('id_pesanan', 'like', "%{$search}%")
                  ->orWhere('ekspedisi', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by expedition
        if ($request->has('ekspedisi') && $request->ekspedisi != '') {
            $query->where('ekspedisi', $request->ekspedisi);
        }

        // Filter by date range
        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('created_at', '>=', $request->date_start);
        }
        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        $pesanan = $query->orderBy('id_pesanan', 'asc')->get();
        $ekspedisiOptions = Pesanan::getEkspedisiOptions();
        return view('admin.pesananproduk.index', compact('pesanan', 'ekspedisiOptions'));
    }

    public function edit($id_pesanan)
    {
        try {
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
            $request->validate([
                'status' => 'required|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan',
                'ekspedisi' => 'required|in:' . implode(',', array_keys(Pesanan::getEkspedisiOptions()))
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