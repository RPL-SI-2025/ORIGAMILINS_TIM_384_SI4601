<?php

namespace App\Http\Controllers;

use App\Models\Payments;
use Illuminate\Http\Request;

class UserPaymentHistoryController extends Controller
{
    public function index()
    {
        $payments = Payments::where('user_id', auth()->id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        return view('user.payments.history', compact('payments'));
    }

    public function show($id)
    {
        $payment = Payments::where('user_id', auth()->id())
                         ->findOrFail($id);
        return view('user.payments.detail', compact('payment'));
    }
} 