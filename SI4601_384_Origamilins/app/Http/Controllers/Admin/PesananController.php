<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Pengrajin;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $search = $request->get('search');

        $query = Pesanan::with(['user', 'produk', 'pengrajin'])
            ->when($search, function ($q) use ($search) {
                return $q->whereHas('user', function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%");
                })->orWhereHas('produk', function ($query) use ($search) {
                    $query->where('nama_produk', 'like', "%{$search}%");
                });
            })
            ->status($status)
            ->orderBy('id_pesanan', 'asc');

        $pesanan = $query->paginate(10);
        
        // Count for each status
        $counts = [
            'total' => Pesanan::count(),
            'rencana' => Pesanan::where('status', 'Rencana')->count(),
            'dalam_proses' => Pesanan::where('status', 'Dalam Proses')->count(),
            'siap_dikirim' => Pesanan::where('status', 'Siap Dikirim')->count(),
            'dikirim' => Pesanan::where('status', 'Dikirim')->count(),
            'selesai' => Pesanan::where('status', 'Selesai')->count(), // <--- INI WAJIB ADA
        ];

        return view('admin.pesananproduk.index', compact('pesanan', 'status', 'counts', 'search'));
    }

    public function edit($id)
    {
        $pesanan = Pesanan::with(['user', 'produk', 'pengrajin'])->findOrFail($id);
        $pengrajinList = Pengrajin::where('is_active', true)->get();
        $statusOptions = Pesanan::getStatusOptions();
        $ekspedisiOptions = Pesanan::getEkspedisiOptions();

        return view('admin.pesananproduk.edit', compact('pesanan', 'pengrajinList', 'statusOptions', 'ekspedisiOptions'));
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Pesanan::getStatusOptions())),
            'pengrajin_id' => 'nullable|exists:pengrajin,id',
            'nomor_resi' => 'required_if:status,Dikirim'
        ]);

        // Tambahan logika otomatis
        if ($pesanan->status === 'Rencana' && $request->pengrajin_id) {
            $request->merge(['status' => 'Dalam Proses']);
        }

        // Jika status berubah ke "Dalam Proses", pastikan ada pengrajin yang ditugaskan
        if ($request->status === 'Dalam Proses' && empty($request->pengrajin_id)) {
            return back()->with('error', 'Pilih pengrajin terlebih dahulu sebelum mengubah status ke Dalam Proses');
        }

        // Jika status berubah ke "Dikirim", pastikan ada nomor resi
        if ($request->status === 'Dikirim' && empty($request->nomor_resi)) {
            return back()->with('error', 'Masukkan nomor resi terlebih dahulu sebelum mengubah status ke Dikirim');
        }

        $pesanan->update([
            'status' => $request->status,
            'pengrajin_id' => $request->pengrajin_id,
            'nomor_resi' => $request->nomor_resi,
            'ekspedisi' => $request->ekspedisi,
            'is_read' => false
        ]);

        // Tambahkan trigger notifikasi di bawah ini
        $user = $pesanan->user;
        $status = $request->status;
        $resi = $request->nomor_resi ?? null;

        $notif = [
            'Rencana'       => ['Pesanan Anda dalam konfirmasi Admin', 'Pesanan Anda telah masuk dan sedang dikonfirmasi oleh admin.'],
            'Dalam Proses'  => ['Pesanan Anda sedang diproses', 'Pesanan Anda sedang diproses oleh pengrajin.'],
            'Siap Dikirim'  => ['Pesanan Anda siap dikirim', 'Pesanan Anda siap dikirim.'],
            'Dikirim'       => ['Pesanan Anda sedang dikirim', 'Pesanan Anda sedang dikirim dengan resi: ' . $resi],
            'Selesai'       => ['Pesanan selesai', 'Pesanan Anda telah diterima. Terima kasih!'],
        ];

        if (isset($notif[$status])) {
            Notification::create([
                'user_id' => $user->id,
                'pesanan_id' => $pesanan->id_pesanan,
                'title'   => $notif[$status][0],
                'message' => $notif[$status][1],
                'is_read' => false,
            ]);
        }

        // Update timestamps berdasarkan status
        if ($request->status === 'Dalam Proses') {
            $pesanan->markAsInProgress();
        } elseif ($request->status === 'Selesai') {
            $pesanan->markAsCompleted();
        }

        return redirect()
            ->route('admin.pesananproduk.index')
            ->with('success', 'Pesanan berhasil diperbarui');
    }

    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'produk', 'pengrajin'])->findOrFail($id);
        return view('admin.pesananproduk.show', compact('pesanan'));
    }

    public function confirmSelesai($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        if ($pesanan->status === 'Dalam Proses') {
            $pesanan->update(['status' => 'Siap Dikirim']);
            // Bisa tambahkan logika lain jika perlu
        }
        return response()->json(['success' => true]);
    }

    public function markSiapDikirim($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        if ($pesanan->status === 'Dalam Proses') {
            $pesanan->update(['status' => 'Siap Dikirim']);
        }
        return response()->json(['success' => true]);
    }
}