<?php
namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Support\Facades\View;
use App\Models\Pesanan;
use App\Models\Notification;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class PaymentsController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show payment form
     */
    public function boot()
{
    View::composer('user.*', function ($view) {
        $notifBelumDibuka = 0;
        if (auth()->check()) {
            $notifBelumDibuka = Pesanan::where('user_id', auth()->id())
                ->whereIn('status', ['Dalam Proses', 'Siap Dikirim', 'Dikirim'])
                ->where('is_read', 0)
                ->count();
        }
        $view->with('notifBelumDibuka', $notifBelumDibuka);
    });
}
    public function create()
    {
        $user = Auth::user();
        $user = auth()->user();
        $cart = $user->cart()->with('items.produk')->first();

        $products = [];
        $subtotal = 0; 
        if ($cart) {
            foreach ($cart->items as $item) {
                $products[] = [
                    'nama' => $item->produk->nama,
                    'deskripsi' => $item->produk->deskripsi,
                    'kategori' => $item->produk->kategori,
                    'gambar' => $item->produk->gambar ?? 'https://via.placeholder.com/80x80?text=IMG',
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                ];
                $subtotal += $item->produk->harga * $item->jumlah; // Hitung subtotal
            }
        }
        $kecamatanList = [
            ['nama' => 'Kiaracondong', 'jarak' => 0],
            ['nama' => 'Antapani', 'jarak' => 2],
            ['nama' => 'Cicadas', 'jarak' => 3],
            ['nama' => 'Lengkong', 'jarak' => 4],
            ['nama' => 'Batununggal', 'jarak' => 2],
            ['nama' => 'Bandung Wetan', 'jarak' => 4],
            ['nama' => 'Cibiru', 'jarak' => 7],
            ['nama' => 'Ujungberung', 'jarak' => 8],
            ['nama' => 'Cilengkrang (Kab. Bandung)', 'jarak' => 10],
            ['nama' => 'Margahayu (Kab. Bandung)', 'jarak' => 13],
            ['nama' => 'Ciparay (Kab. Bandung)', 'jarak' => 17],
            ['nama' => 'Dayeuhkolot (Kab. Bandung)', 'jarak' => 11],
            ['nama' => 'Baleendah (Kab. Bandung)', 'jarak' => 13],
            ['nama' => 'Banjaran (Kab. Bandung)', 'jarak' => 18],
            ['nama' => 'Soreang (Kab. Bandung)', 'jarak' => 22],
            ['nama' => 'Margaasih (Kab. Bandung)', 'jarak' => 14],
            ['nama' => 'Katapang (Kab. Bandung)', 'jarak' => 16],
            ['nama' => 'Cimahi Utara', 'jarak' => 13],
            ['nama' => 'Cimahi Tengah', 'jarak' => 12],
            ['nama' => 'Cimahi Selatan', 'jarak' => 14],
            ['nama' => 'Padalarang (Bandung Barat)', 'jarak' => 22],
            ['nama' => 'Ngamprah (Bandung Barat)', 'jarak' => 20],
            ['nama' => 'Lembang (Bandung Barat)', 'jarak' => 21],
    ];

    $notifBelumDibuka = Pesanan::where('user_id', auth()->id())
        ->whereIn('status', ['Dalam Proses', 'Siap Dikirim', 'Dikirim'])
        ->where('is_read', 0)
        ->count();

    $notifikasi = Notification::where('user_id', auth()->id())
        ->orderBy('created_at', 'desc')
        ->take(10)
        ->get();
         return view('user.payments.create', compact('products', 'kecamatanList', 'subtotal', 'notifBelumDibuka', 'notifikasi'));
    }

    public function index()
    {
        return view('user.payments.create');
    }

    /**
     * Proses data pengiriman dan langsung proses pembayaran (langsung ke checkout)
     */
    public function shipping(Request $request)
{
    $cart = auth()->user()->cart;
    $items = $cart ? $cart->items()->with('produk')->get() : collect();
    $alamat = $request->only([
        'nama_awal', 'nama_akhir', 'alamat', 'blok_gang', 'kecamatan', 'kota', 'provinsi', 'kode_pos', 'country_code', 'phone', 'shipping_method', 'email'
    ]);
    $subtotal = $request->subtotal;
    $ongkir = $request->ongkir;
    $total = $request->total;

    // Validasi data
    $request->validate([
        'nama_awal' => 'required|string|max:255',
        'nama_akhir' => 'nullable|string|max:255',
        'total' => 'required|numeric|min:10000',
        'email' => 'required|email',
    ]);

    // Generate unique order ID
    $orderId = 'ORDER-' . Str::random(10) . '-' . time();

    // Siapkan data items untuk disimpan di metadata
    $itemsData = [];
    foreach ($items as $item) {
        $itemsData[] = [
            'produk_id' => $item->produk_id,
            'nama' => $item->produk->nama,
            'deskripsi' => $item->produk->deskripsi,
            'kategori' => $item->produk->kategori,
            'gambar' => $item->produk->gambar,
            'harga' => $item->produk->harga,
            'jumlah' => $item->jumlah,
            'total_harga' => $item->produk->harga * $item->jumlah,
        ];
    }

    // Buat record payment
    $payment = Payments::create([
        'order_id' => $orderId,
        'user_id' => auth()->id(),
        'nama' => $alamat['nama_awal'] . ' ' . ($alamat['nama_akhir'] ?? ''),
        'email' => $alamat['email'],
        'total' => $total,
        'status' => 'pending',
        'metadata' => [
            'alamat' => $alamat,
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total' => $total,
            'items' => $itemsData,
        ],
    ]);

    // Siapkan parameter Midtrans
    $params = [
        'transaction_details' => [
            'order_id' => $payment->order_id,
            'gross_amount' => (int) $payment->total,
        ],
        'customer_details' => [
            'first_name' => $payment->nama,
            'email' => $payment->email,
        ],
        'callbacks' => [
            'finish' => route('user.payments.finish', $payment->id),
        ],
    ];

    // Ambil Snap token
    $snapResponse = $this->midtransService->getSnapToken($params);

    if (!$snapResponse['success']) {
        return redirect()->back()->with('error', 'Failed to process payment: ' . $snapResponse['message']);
    }

    // Update payment dengan snap token
    $payment->update([
        'snap_token' => $snapResponse['token'],
    ]);

    // Kirim data ke checkout
    return view('user.payments.checkout', [
        'items' => $items,
        'subtotal' => $subtotal,
        'ongkir' => $ongkir,
        'total' => $total,
        'alamat' => $alamat,
        'payment' => $payment,
        'snapResponse' => $snapResponse,
    ]);
}

    /**
     * Tidak digunakan lagi, kecuali untuk menampilkan ulang jika user reload setelah store
     */
    public function checkout()
    {
        // Optional: bisa redirect ke create atau tampilkan pesan error
        return redirect()->route('user.payments.create');
    }

    /**
     * Handle callback notification from Midtrans
     */
    public function callback()
    {
        $notification = $this->midtransService->processNotification();

    if (is_array($notification) && isset($notification['success']) && !$notification['success']) {
        return response()->json(['status' => 'error', 'message' => $notification['message']], 500);
    }

        $orderId = $notification->order_id;
        $transactionStatus = $notification->transaction_status;
        $fraudStatus = $notification->fraud_status;
        $transactionId = $notification->transaction_id;
        $paymentType = $notification->payment_type;

        // Get the payment record
        $payment = Payments::where('order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['status' => 'error', 'message' => 'Payment not found'], 404);
        }

        // Update payment status based on notification
        $payment->transaction_id = $transactionId;
        $payment->payment_type = $paymentType;
        $payment->metadata = json_decode(json_encode($notification), true);

        // Handle transaction status
        if ($transactionStatus == 'capture') {
            // Untuk credit_card, cek fraud_status
            if (isset($fraudStatus)) {
                if ($fraudStatus == 'challenge') {
                    $payment->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $payment->status = 'success';
                    $payment->paid_at = now();
                } else {
                    $payment->status = $fraudStatus; // fallback jika fraud_status tidak dikenal
                }
            } else {
                // Jika tidak ada fraud_status, anggap sukses
                $payment->status = 'success';
                $payment->paid_at = now();
            }
        } else if ($transactionStatus == 'settlement') {
            $payment->status = 'success';
            $payment->paid_at = now();
        } else if (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
            $payment->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $payment->status = 'pending';
        } else {
            // Log jika ada status tidak dikenal
            \Log::warning('Midtrans unknown transaction status', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus ?? null,
            ]);
        }

        $payment->save();
    
        // Return OK to Midtrans
        return response()->json(['status' => 'ok']);
    }
    /**
     * Handle completed payment redirect
     */
    public function finish($id)
{
    $payment = Payments::findOrFail($id);

    // Ambil data alamat, subtotal, ongkir, total dari kolom metadata (jika ada)
    $alamat = $payment->metadata['alamat'] ?? [];
    $subtotal = $payment->metadata['subtotal'] ?? 0;
    $ongkir = $payment->metadata['ongkir'] ?? 0;
    $total = $payment->metadata['total'] ?? 0;

    // Check the latest status from Midtrans
    $statusResponse = $this->midtransService->checkTransactionStatus($payment->order_id);

    $transactionStatus = null;
    if ($statusResponse['success']) {
        $transactionStatus = $statusResponse['status']->transaction_status ?? null;

        if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
            if ($payment->status != 'success') {
                $payment->status = 'success';
                $payment->paid_at = now();
                $payment->save();

                // Proses pembuatan pesanan
                $user = auth()->user();
                $cart = $user->cart()->with('items.produk')->first();
                if ($cart && $cart->items->count() > 0) {
                    foreach ($cart->items as $item) {
                        Pesanan::create([
                            'user_id' => $user->id,
                            'produk_id' => $item->produk_id,
                            'jumlah' => $item->jumlah,
                            'total_harga' => $item->produk->harga * $item->jumlah,
                            'status' => 'Rencana',
                            'payment_id' => $payment->id,
                            'alamat_pengiriman' => json_encode($alamat), // Pastikan ini di-encode sebagai JSON
                        ]);
                    }
                    // Kosongkan cart setelah checkout
                    $cart->items()->delete();
                }
            }
        }
    }

    // Ambil data items untuk ditampilkan
    $items = collect();
    
    // Coba ambil dari pesanan yang sudah dibuat
    $pesananItems = Pesanan::where('payment_id', $payment->id)
        ->with('produk')
        ->get();
    
    if ($pesananItems->count() > 0) {
        $items = $pesananItems;
    } else {
        // Jika belum ada pesanan, ambil dari cart (fallback)
        $user = auth()->user();
        $cart = $user->cart()->with('items.produk')->first();
        if ($cart && $cart->items->count() > 0) {
            $items = $cart->items;
        } else {
            // Jika cart sudah kosong, coba ambil dari metadata payment
            if (isset($payment->metadata['items'])) {
                $items = collect($payment->metadata['items']);
            }
        }
    }

    // Debug: log data untuk troubleshooting
    \Log::info('Payment finish debug', [
        'payment_id' => $payment->id,
        'transaction_status' => $transactionStatus,
        'items_count' => $items->count(),
        'pesanan_count' => $pesananItems->count(),
    ]);

    // Jika status success, tampilkan halaman success
    if ($transactionStatus == 'settlement' || $transactionStatus == 'capture' || $payment->status == 'success') {
        return view('user.payments.success', compact('payment', 'alamat', 'subtotal', 'ongkir', 'total', 'items'));
    }

    // Jika status tidak success, tampilkan pesan error
    return view('user.payments.error', [
        'message' => 'Pembayaran tidak berhasil. Silakan coba lagi.',
        'payment' => $payment,
        'alamat' => $alamat,
        'items' => $items,
    ]);
}
public function success($order_id)
{
    $payment = Payments::where('order_id', $order_id)->firstOrFail();

    // Ambil data alamat, subtotal, ongkir, total dari metadata
    $alamat = $payment->metadata['alamat'] ?? [];
    $subtotal = $payment->metadata['subtotal'] ?? 0;
    $ongkir = $payment->metadata['ongkir'] ?? 0;
    $total = $payment->metadata['total'] ?? 0;

    // Ambil data items dari pesanan jika sudah ada, fallback ke metadata jika belum
    $items = Pesanan::where('payment_id', $payment->id)
        ->with('produk')
        ->get();

    if ($items->count() == 0 && isset($payment->metadata['items'])) {
        // Fallback ke metadata jika pesanan belum ada
        $items = collect($payment->metadata['items']);
    }

    return view('user.payments.success', compact('payment', 'items', 'alamat', 'subtotal', 'ongkir', 'total'));
}
}
