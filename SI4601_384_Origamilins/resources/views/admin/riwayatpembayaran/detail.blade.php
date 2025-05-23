@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mt-4">
        <h1>Detail Pembayaran</h1>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-info-circle me-1"></i>
            Informasi Pembayaran
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table">
                        <tr>
                            <th width="200">ID Transaksi</th>
                            <td>{{ $payment->order_id }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pengguna</th>
                            <td>{{ $payment->nama }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Transaksi</th>
                            <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Nominal</th>
                            <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ $payment->payment_type ?? 'Belum dipilih' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($payment->status == 'success')
                                    <span class="badge bg-success">Sukses</span>
                                @elseif($payment->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($payment->status == 'failed')
                                    <span class="badge bg-danger">Gagal</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <i class="fas fa-history me-1"></i>
                            Riwayat Status
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Pembayaran Dibuat
                                    <span class="text-muted">{{ $payment->created_at->format('d/m/Y H:i') }}</span>
                                </li>
                                @if($payment->paid_at)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Pembayaran Selesai
                                    <span class="text-muted">{{ $payment->paid_at->format('d/m/Y H:i') }}</span>
                                </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 