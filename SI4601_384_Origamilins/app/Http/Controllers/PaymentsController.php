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
    public function index()
    {
        return view('user.payments.create');
    }

    /**
     * Create a new payment and get Midtrans Snap token
     */
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
                'gross_amount' => (int) $payment->total, // Menggunakan 'total'
            ],
            'customer_details' => [
                'first_name' => $payment->nama, // Menggunakan 'nama'
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