<?php

namespace App\Http\Controllers;

use App\Models\PesananEvent;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PesananEventController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['index']);
    }

    public function index()
    {
        $pesanan = PesananEvent::latest()->get();
        return view('admin.pesananevent.index', compact('pesanan'));
    }

    public function edit($id_pesanan_event)
    {
        try {
            $pesanan = PesananEvent::findOrFail($id_pesanan_event);
            $statusOptions = PesananEvent::getStatusOptions();
            return view('admin.pesananevent.edit', compact('pesanan', 'statusOptions'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pesananevent.index')
                ->with('error', 'Pesanan event tidak ditemukan');
        }
    }

    public function update(Request $request, $id_pesanan_event)
    {
        try {
            $request->validate([
                'status' => 'required|in:Menunggu,Dikonfirmasi,Selesai,Dibatalkan'
            ]);

            $pesanan = PesananEvent::findOrFail($id_pesanan_event);
            $pesanan->update([
                'status' => $request->status
            ]);

            return redirect()->route('admin.pesananevent.index')
                ->with('success', 'Status pesanan event berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui status pesanan event: ' . $e->getMessage());
        }
    }
} 