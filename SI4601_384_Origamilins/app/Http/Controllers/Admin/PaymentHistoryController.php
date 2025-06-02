<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentHistoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Payments::with('user')->orderBy('created_at', 'desc');

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
                  ->orWhere('nama', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $payments = $query->paginate(10);

        // Get all possible statuses for filter dropdown
        $statuses = [
            'pending' => 'Menunggu Pembayaran',
            'success' => 'Pembayaran Berhasil',
            'failed' => 'Pembayaran Gagal',
            'refund_requested' => 'Refund Diminta',
            'refunded' => 'Refund Diterima',
            'refund_rejected' => 'Refund Ditolak'
        ];

        return view('admin.riwayatpembayaran.history', compact('payments', 'statuses'));
    }

    public function show($id)
    {
        $payment = Payments::with('user')->findOrFail($id);
        return view('admin.riwayatpembayaran.detail', compact('payment'));
    }
} 