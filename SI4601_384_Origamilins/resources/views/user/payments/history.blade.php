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
                                        <th>Nama</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <td>{{ $payment->order_id }}</td>
                                            <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                                            <td>{{ $payment->nama }}</td>
                                            <td>Rp {{ number_format($payment->total, 0, ',', '.') }}</td>
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
                                                    @default
                                                        <span class="badge bg-secondary">{{ $payment->status }}</span>
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