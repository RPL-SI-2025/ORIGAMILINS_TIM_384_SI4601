<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserEventController extends Controller
{
    /**
     * Display a listing of the events for user.
     */
    public function index(Request $request)
    {
        // Tidak perlu cek admin, ini untuk user
        $query = Event::query();

        // Filter berdasarkan Nama Event
        if ($request->filled('nama')) {
            $query->where('nama_event', 'like', '%' . $request->input('nama') . '%');
        }

        // Filter berdasarkan Lokasi
        if ($request->filled('lokasi')) {
            $query->where('lokasi', 'like', '%' . $request->input('lokasi') . '%');
        }

        // Filter berdasarkan Tanggal Pelaksanaan
        if ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal_pelaksanaan', '>=', $request->input('tanggal_mulai'));
        }
        if ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal_pelaksanaan', '<=', $request->input('tanggal_akhir'));
        }

        // Filter berdasarkan Rentang Harga
        if ($request->filled('harga_min')) {
            $query->where('harga', '>=', $request->input('harga_min'));
        }
        if ($request->filled('harga_max')) {
            $query->where('harga', '<=', $request->input('harga_max'));
        }

        // Ambil event yang sudah difilter
        $events = $query->orderBy('tanggal_pelaksanaan')->get();

        // Kirim data ke view user.event.index
        return view('user.event.index', [
            'events' => $events,
            'request' => $request
        ]);
    }

    /**
     * Show detail event.
     */
    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.show', compact('event'));
    }

    /**
     * Show form pendaftaran event.
     */
    public function registerForm($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.register', compact('event'));
    }

    /**
     * Handle pendaftaran event.
     */
    public function register(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'telepon' => 'required|string|max:20',
            'jumlah_tiket' => 'required|integer|min:1',
            'metode_pembayaran' => 'required|string',
            'catatan' => 'nullable|string',
        ]);

        $event = Event::findOrFail($id);

        // Simpan pendaftaran (status pending)
        $registration = \App\Models\EventRegistration::create([
            'event_id' => $id,
            'user_id' => Auth::id(),
            'nama' => $request->nama,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'jumlah_tiket' => $request->jumlah_tiket,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        // Midtrans Snap
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'EVT-' . $registration->id . '-' . time(),
                'gross_amount' => $event->harga * $request->jumlah_tiket,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'email' => $request->email,
                'phone' => $request->telepon,
            ],
            'item_details' => [
                [
                    'id' => $event->id,
                    'price' => $event->harga,
                    'quantity' => $request->jumlah_tiket,
                    'name' => $event->nama_event,
                ]
            ]
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken,
            'redirect_url' => route('user.event.show', $event->id)
        ]);
    }
}
