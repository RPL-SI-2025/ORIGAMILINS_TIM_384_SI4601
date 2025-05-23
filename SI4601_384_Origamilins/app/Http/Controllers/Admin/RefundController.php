<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function index(Request $request)
    {
        $query = Payments::where(function($q) {
            $q->where('status', Payments::STATUS_REFUND_REQUESTED)
              ->orWhere('status', Payments::STATUS_REFUNDED)
              ->orWhere('status', Payments::STATUS_REFUND_REJECTED);
        });

        // Filter by date range
        if ($request->filled(['start_date', 'end_date'])) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by search term
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        $refunds = $query->orderBy('created_at', 'desc')->paginate(10);

        // Get all possible statuses for filter dropdown
        $statuses = [
            Payments::STATUS_REFUND_REQUESTED => 'Menunggu Refund',
            Payments::STATUS_REFUNDED => 'Refund Diterima',
            Payments::STATUS_REFUND_REJECTED => 'Refund Ditolak'
        ];

        return view('admin.refund.index', compact('refunds', 'statuses'));
    }

    public function show($id)
    {
        $payment = Payments::findOrFail($id);
        return view('admin.refund.show', compact('payment'));
    }

    public function processRefund(Request $request, $id)
    {
        $payment = Payments::findOrFail($id);
        
        if ($payment->status !== Payments::STATUS_REFUND_REQUESTED) {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid untuk refund.');
        }

        try {
            // Process refund through Midtrans
            $refundResponse = $this->midtransService->refundTransaction($payment->order_id, [
                'amount' => $payment->total,
                'reason' => $request->reason ?? 'Refund processed by admin'
            ]);

            if ($refundResponse['success']) {
                $payment->update([
                    'status' => Payments::STATUS_REFUNDED,
                    'refunded_at' => now(),
                    'refund_reason' => $request->reason,
                    'refund_metadata' => $refundResponse['data'] ?? null
                ]);

                return redirect()->route('admin.refunds.index')
                    ->with('success', 'Refund berhasil diproses.');
            } else {
                return redirect()->back()
                    ->with('error', 'Gagal memproses refund: ' . $refundResponse['message']);
            }
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function rejectRefund(Request $request, $id)
    {
        $payment = Payments::findOrFail($id);
        
        if ($payment->status !== Payments::STATUS_REFUND_REQUESTED) {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid untuk penolakan refund.');
        }

        $payment->update([
            'status' => Payments::STATUS_REFUND_REJECTED,
            'refund_reason' => $request->reason,
            'refund_rejected_at' => now()
        ]);

        return redirect()->route('admin.refunds.index')
            ->with('success', 'Permintaan refund telah ditolak.');
    }
} 