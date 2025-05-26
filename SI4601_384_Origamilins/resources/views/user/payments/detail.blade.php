@extends('layouts.app')

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
                                            @case('success')
                                                <span class="badge bg-success">Sukses</span>
                                                @break
                                            @case('pending')
                                                <span class="badge bg-warning">Menunggu</span>
                                                @break
                                            @case('failed')
                                                <span class="badge bg-danger">Gagal</span>
                                                @break
                                            @case('refund_requested')
                                                <span class="badge bg-info">Refund Diminta</span>
                                                @break
                                            @case('refunded')
                                                <span class="badge bg-primary">Dikembalikan</span>
                                                @break
                                            @case('refund_rejected')
                                                <span class="badge bg-danger">Refund Ditolak</span>
                                                @break
                                            @default
                                                <span class="badge bg-secondary">{{ $payment->status }}</span>
                                        @endswitch
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="text-muted mb-3">Informasi Pembayaran</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="40%">Nama</th>
                                    <td>{{ $payment->nama }}</td>
                                </tr>
                                <tr>
                                    <th>Total</th>
                                    <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th>Metode Pembayaran</th>
                                    <td>{{ $payment->payment_type ?? '-' }}</td>
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

                    @if($payment->status === 'refund_rejected')
                        <div class="alert alert-danger">
                            <h5 class="alert-heading">Refund Ditolak</h5>
                            <p class="mb-0">Ditolak pada: {{ $payment->refund_rejected_at->format('d M Y H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 