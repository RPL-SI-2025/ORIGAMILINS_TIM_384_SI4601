@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Riwayat Transaksi</h4>
                </div>
                <div class="card-body">
                    @if($payments->isEmpty())
                        <div class="text-center py-4">
                            <p class="text-muted mb-0">Belum ada riwayat transaksi</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID Transaksi</th>
                                        <th>Tanggal</th>
                                        <th>Total</th>
                                        <th>Metode Pembayaran</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->order_id }}</td>
                                            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                            <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                                            <td>
                                                @switch($payment->payment_type)
                                                    @case('bank_transfer')
                                                        Transfer Bank
                                                        @break
                                                    @case('credit_card')
                                                        Kartu Kredit
                                                        @break
                                                    @case('e_wallet')
                                                        E-Wallet
                                                        @break
                                                    @case('gopay')
                                                        GoPay
                                                        @break
                                                    @case('shopeepay')
                                                        ShopeePay
                                                        @break
                                                    @case('qris')
                                                        QRIS
                                                        @break
                                                    @default
                                                        {{ $payment->payment_type ?? '-' }}
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($payment->status)
                                                    @case('pending')
                                                        <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                                                        @break
                                                    @case('success')
                                                        <span class="badge bg-success text-white">Pembayaran Berhasil</span>
                                                        @break
                                                    @case('failed')
                                                        <span class="badge bg-danger text-white">Pembayaran Gagal</span>
                                                        @break
                                                    @case('refund_requested')
                                                        <span class="badge bg-info text-white">Refund Diminta</span>
                                                        @break
                                                    @case('refunded')
                                                        <span class="badge bg-success text-white">Refund Diterima</span>
                                                        @break
                                                    @case('refund_rejected')
                                                        <span class="badge bg-danger text-white">Refund Ditolak</span>
                                                        @break
                                                    @default
                                                        <span class="badge bg-secondary text-white">{{ $payment->status }}</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                <a href="{{ route('user.payments.show', $payment->id) }}" 
                                                   class="btn btn-sm btn-info">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                            {{ $payments->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 