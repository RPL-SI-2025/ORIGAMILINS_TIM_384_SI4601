<?php
namespace App\Http\Controllers;

use App\Models\Payments;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function create()
    {
    $user = auth()->user();
    $cart = $user->cart()->with('items.produk')->first();

    $products = [];
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

        return view('user.payments.create', compact('products', 'kecamatanList'));
    }
    public function index()
    {
        return view('user.payments.create');
    }

    public function shipping(Request $request)
    {
        $cart = auth()->user()->cart;
        $items = $cart ? $cart->items()->with('produk')->get() : collect();
        $alamat = $request->only([
            'nama_awal', 'nama_akhir', 'alamat', 'blok_gang', 'kecamatan', 'kota', 'provinsi', 'kode_pos', 'country_code', 'phone', 'shipping_method'
        ]);
        $subtotal = $request->subtotal;
        $ongkir = $request->ongkir;
        $total = $request->total;
        $payment =     $payment = (object)[
        'order_id' => 'INV-' . time(),
        'email' => $request->email,
        'snap_token' => 'dummy-snap-token',
        'id' => 1, 
    ];
; 

        // Simpan ke session
        session([
            'items' => $items,
            'alamat' => $alamat,
            'subtotal' => $subtotal,
            'ongkir' => $ongkir,
            'total' => $total,
            'payment' => $payment,
        ]);

        return redirect()->route('user.payments.checkout');
    }

    /**
     * Create a new payment and get Midtrans Snap token
     */
        public function saveShipping(Request $request)
    {
        session(['cart_items' => $request->items]);
        session(['jarak_kecamatan' => $request->jarak_kecamatan]);
        return redirect()->route('user.payments.shipping');
    }
    public function store(Request $request)
    {

        
        $request->validate([
            'nama' => 'required|string|max:255',
            'total' => 'required|numeric|min:10000',
        ]);

        // Generate unique order ID
        $orderId = 'ORDER-' . Str::random(10) . '-' . time();

        // Create payment record
        $payment = Payments::create([
            'order_id' => $orderId,
            'total' => $request->total, 
            'nama' => $request->nama, 
            'status' => 'pending',
        ]);

        // Prepare Midtrans parameters
        $params = [
            'transaction_details' => [
                'order_id' => $payment->order_id,
                'gross_amount' => (int) $payment->total, 
            ],
            'customer_details' => [
                'first_name' => $payment->nama, 
            ],
            'callbacks' => [
                'finish' => route('user.payments.finish', $payment->id),
            ],
        ];
        

        // Get Snap token
        $snapResponse = $this->midtransService->getSnapToken($params);

        if (!$snapResponse['success']) {
            return redirect()->back()->with('error', 'Failed to process payment: ' . $snapResponse['message']);
        }

        // Update payment with snap token
        $payment->update([
            'snap_token' => $snapResponse['token'],
        ]);

        return view('user.payments.checkout', compact('payment', 'snapResponse'));
    }

    public function checkout()
    {
        $items = session('items'); 
        $subtotal = session('subtotal');
        $ongkir = session('ongkir');
        $total = session('total');
        $payment = session('payment'); 

        if (!$items) {
            return redirect()->route('user.payments.create')->with('error', 'Data tidak ditemukan.');
        }

        return view('user.payments.checkout', compact('items', 'payment'));
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
            if ($fraudStatus == 'challenge') {
                $payment->status = 'challenge';
            } else if ($fraudStatus == 'accept') {
                $payment->status = 'success';
                $payment->paid_at = now();
            }
        } else if ($transactionStatus == 'settlement') {
            $payment->status = 'success';
            $payment->paid_at = now();
        } else if ($transactionStatus == 'cancel' || $transactionStatus == 'deny' || $transactionStatus == 'expire') {
            $payment->status = 'failed';
        } else if ($transactionStatus == 'pending') {
            $payment->status = 'pending';
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
        
        // Check the latest status from Midtrans
        $statusResponse = $this->midtransService->checkTransactionStatus($payment->order_id);
        
        if ($statusResponse['success']) {
            $transactionStatus = $statusResponse['status']->transaction_status ?? null;
            
            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                if ($payment->status != 'success') {
                    $payment->status = 'success';
                    $payment->paid_at = now();
                    $payment->save();
                }
                return view('user.payments.success', compact('payment'));
            }
        }
        
        return view('user.payments.status', compact('payment'));
    }
}