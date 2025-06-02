<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PesananEvent;

class UserEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
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

    public function show($id)
    {
        $event = Event::findOrFail($id);
        return view('user.event.show', compact('event'));
    }

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
public function registerForm($id)
{
    $event = Event::findOrFail($id);
    return view('user.event.register', compact('event'));
}
}