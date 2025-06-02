@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Transaksi</h4>
                    <a href="{{ route('user.payments.history') }}" class="btn btn-secondary btn-sm">
                        Kembali
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Informasi Transaksi</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">ID Transaksi</th>
                                    <td>{{ $payment->order_id }}</td>
                                </tr>
                                <tr>
                                    <th>Tanggal</th>
                                    <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
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
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Informasi Pembayaran</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Total</th>
                                    <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
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
                                </tr>
                            </table>
                        </div>
                    </div>

                    @if($payment->status === 'refund_requested')
                        <div class="alert alert-info">
                            <h5 class="alert-heading">Informasi Refund</h5>
                            <p class="mb-0">Alasan refund: {{ $payment->refund_reason }}</p>
                            <p class="mb-0">Tanggal request: {{ $payment->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif

                    @if($payment->status === 'refunded')
                        <div class="alert alert-success">
                            <h5 class="alert-heading">Refund Berhasil</h5>
                            <p class="mb-0">Dikembalikan pada: {{ $payment->refunded_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif

                    @if($payment->status === 'pending')
                        <div class="alert alert-warning">
                            <h5 class="alert-heading">Pembayaran Menunggu</h5>
                            <p class="mb-0">Silakan selesaikan pembayaran Anda sesuai dengan metode yang dipilih.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 