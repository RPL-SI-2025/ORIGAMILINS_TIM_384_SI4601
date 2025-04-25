<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PesananEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananEventController extends Controller
{
    public function __construct()
    {
        // Hapus middleware dari constructor
    }

    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login');
        }

        $query = PesananEvent::query();

        // Search with partial word matching
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_pemesan', 'like', "%{$search}%")
                  ->orWhere('nama_event', 'like', "%{$search}%")
                  ->orWhere('id_pesanan_event', 'like', "%{$search}%")
                  ->orWhere('status', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->has('date_start') && $request->date_start != '') {
            $query->whereDate('created_at', '>=', $request->date_start);
        }
        if ($request->has('date_end') && $request->date_end != '') {
            $query->whereDate('created_at', '<=', $request->date_end);
        }

        $pesanan = $query->orderBy('id_pesanan_event', 'asc')->get();
        $statusOptions = PesananEvent::getStatusOptions();
        return view('admin.pesananevent.index', compact('pesanan', 'statusOptions'));
    }

    public function edit($id_pesanan_event)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login');
        }

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
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/login');
        }

        try {
            $request->validate([
                'status' => 'required|in:Menunggu,Belum Berjalan,Sedang Berjalan,Selesai,Dibatalkan'
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