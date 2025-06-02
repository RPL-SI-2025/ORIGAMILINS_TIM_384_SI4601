@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Pembayaran</h3>
                </div>
                <div class="card-body">
                    <!-- Filter Form -->
                    <form action="{{ route('admin.payments.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="search">Cari</label>
                                    <input type="text" class="form-control" id="search" name="search" 
                                           value="{{ request('search') }}" placeholder="Cari order ID, nama, atau ID transaksi...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="start_date">Tanggal Mulai</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                           value="{{ request('start_date') }}">
                                </div>
                            </div>
                            <div class="col-md-4 mt-3">
                                <div class="form-group">
                                    <label for="end_date">Tanggal Akhir</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" 
                                           value="{{ request('end_date') }}">
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Filter</button>
                                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Reset</a>
                            </div>
                        </div>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Nama</th>
                                    <th>User</th>
                                    <th>Total</th>
                                    <th>Metode Pembayaran</th>
                                    <th>Status</th>
                                    <th>Tanggal</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->order_id }}</td>
                                        <td>{{ $payment->nama }}</td>
                                        <td>
                                            @if($payment->user)
                                                {{ $payment->user->name }}<br>
                                                <small class="text-muted">{{ $payment->user->email }}</small>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
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
                                                    {{ $payment->payment_type }}
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
                                        <td>{{ $payment->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.payments.show', $payment->id) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="fas fa-eye"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data pembayaran</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $payments->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 