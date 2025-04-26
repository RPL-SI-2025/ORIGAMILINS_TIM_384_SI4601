@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Pesanan</h1>
    
    <div class="card mb-4">
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('admin.pesananproduk.index') }}" method="GET" class="mb-4">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Cari pesanan..." value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>

            <!-- Status Tabs -->
            <ul class="nav nav-tabs mb-4">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('admin.pesananproduk.index') }}">
                        Semua <span class="badge bg-secondary">{{ $counts['total'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'Rencana' ? 'active' : '' }}" 
                       href="{{ route('admin.pesananproduk.index', ['status' => 'Rencana']) }}">
                        Rencana <span class="badge bg-warning">{{ $counts['rencana'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'Dalam Proses' ? 'active' : '' }}"
                       href="{{ route('admin.pesananproduk.index', ['status' => 'Dalam Proses']) }}">
                        Dalam Proses <span class="badge bg-info">{{ $counts['dalam_proses'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'Siap Dikirim' ? 'active' : '' }}"
                       href="{{ route('admin.pesananproduk.index', ['status' => 'Siap Dikirim']) }}">
                        Siap Dikirim <span class="badge bg-primary">{{ $counts['siap_dikirim'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'Dikirim' ? 'active' : '' }}"
                       href="{{ route('admin.pesananproduk.index', ['status' => 'Dikirim']) }}">
                        Dikirim <span class="badge bg-purple">{{ $counts['dikirim'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'Selesai' ? 'active' : '' }}"
                       href="{{ route('admin.pesananproduk.index', ['status' => 'Selesai']) }}">
                        Selesai <span class="badge bg-success">{{ $counts['selesai'] }}</span>
                    </a>
                </li>
            </ul>

            <!-- Pesanan Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Nama Pemesan</th>
                            <th>Produk</th>
                            <th>Total</th>
                            <th>Pengrajin</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $order)
                            <tr>
                                <td>{{ $order->id_pesanan }}</td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ $order->user->name }}</td>
                                <td>
                                    {{ $order->produk->nama_produk }}<br>
                                    <small class="text-muted">{{ $order->jumlah }} unit</small>
                                </td>
                                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if($order->pengrajin)
                                        <span class="badge bg-info">{{ $order->pengrajin->nama }}</span>
                                    @else
                                        <span class="badge bg-secondary">Belum ditugaskan</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $order->status_badge }}">{{ $order->status }}</span>
                                    @if($order->status === 'Dikirim')
                                        <br>
                                        <small class="text-muted">
                                            {{ $order->ekspedisi }} - {{ $order->nomor_resi }}
                                        </small>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pesananproduk.show', $order->id_pesanan) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.pesananproduk.edit', $order->id_pesanan) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">Tidak ada pesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $pesanan->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<style>
.badge {
    font-size: 0.875rem;
    padding: 0.5em 1em;
}

.bg-purple {
    background-color: #6f42c1;
}

.nav-tabs .nav-link {
    color: #6c757d;
}

.nav-tabs .nav-link.active {
    color: #495057;
    font-weight: 500;
}

.table td {
    vertical-align: middle;
}
</style>
@endsection 