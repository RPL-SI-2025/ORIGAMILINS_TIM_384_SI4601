@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Detail Pesanan #{{ $pesanan->id_pesanan }}</h2>
        <a href="{{ route('admin.pesananproduk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Detail Produk</h6>
                            <p class="mb-1"><strong>Nama Produk:</strong> {{ $pesanan->produk->nama_produk }}</p>
                            <p class="mb-1"><strong>Jumlah:</strong> {{ $pesanan->jumlah }} unit</p>
                            <p class="mb-1"><strong>Total Harga:</strong> Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Status Pembayaran</h6>
                            <p class="mb-1">
                                <strong>Status:</strong> 
                                <span class="badge {{ $pesanan->status_pembayaran === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $pesanan->status_pembayaran === 'Paid' ? 'Lunas' : 'Belum Lunas' }}
                                </span>
                            </p>
                            @if($pesanan->status_pembayaran === 'Paid')
                                <p class="mb-1"><strong>Tanggal Pembayaran:</strong> {{ $pesanan->tanggal_pembayaran ? $pesanan->tanggal_pembayaran->format('d/m/Y H:i') : '-' }}</p>
                                <p class="mb-1"><strong>Metode Pembayaran:</strong> {{ $pesanan->metode_pembayaran ?? '-' }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Status Pesanan</h6>
                            <p class="mb-1">
                                <strong>Status:</strong> 
                                <span class="badge {{ $pesanan->status_badge }}">{{ $pesanan->status }}</span>
                            </p>
                            @if($pesanan->pengrajin)
                                <p class="mb-1">
                                    <strong>Pengrajin:</strong>
                                    <span class="badge bg-info">{{ $pesanan->pengrajin->nama }}</span>
                                </p>
                            @endif
                            @if($pesanan->status === 'Dikirim')
                                <p class="mb-1"><strong>Ekspedisi:</strong> {{ $pesanan->ekspedisi }}</p>
                                <p class="mb-1"><strong>Nomor Resi:</strong> {{ $pesanan->nomor_resi }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Informasi Pelanggan</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $pesanan->user->name }}</p>
                            <p class="mb-1"><strong>Telepon:</strong> {{ $pesanan->nomor_telepon }}</p>
                            <p class="mb-1"><strong>Alamat:</strong> {{ $pesanan->alamat_pengiriman }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Waktu Pesanan</h6>
                            <p class="mb-1"><strong>Dibuat:</strong> {{ $pesanan->created_at->format('d/m/Y H:i') }}</p>
                            @if($pesanan->tanggal_pesanan)
                                <p class="mb-1"><strong>Mulai Proses:</strong> {{ $pesanan->tanggal_pesanan->format('d/m/Y H:i') }}</p>
                            @endif
                            @if($pesanan->tanggal_selesai)
                                <p class="mb-1"><strong>Selesai:</strong> {{ $pesanan->tanggal_selesai->format('d/m/Y H:i') }}</p>
                            @endif
                        </div>
                    </div>

                    @if($pesanan->catatan)
                        <div class="mt-4">
                            <h6 class="text-muted mb-3">Catatan Pesanan</h6>
                            <p class="mb-0">{{ $pesanan->catatan }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">Aksi</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.pesananproduk.edit', $pesanan->id_pesanan) }}" 
                           class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Pesanan
                        </a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Timeline Status</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <div class="list-group-item {{ $pesanan->status === 'Rencana' ? 'active' : '' }}">
                            <i class="fas fa-clock me-2"></i> Rencana
                        </div>
                        <div class="list-group-item {{ $pesanan->status === 'Dalam Proses' ? 'active' : '' }}">
                            <i class="fas fa-cog me-2"></i> Dalam Proses
                        </div>
                        <div class="list-group-item {{ $pesanan->status === 'Siap Dikirim' ? 'active' : '' }}">
                            <i class="fas fa-box me-2"></i> Siap Dikirim
                        </div>
                        <div class="list-group-item {{ $pesanan->status === 'Dikirim' ? 'active' : '' }}">
                            <i class="fas fa-truck me-2"></i> Dikirim
                        </div>
                        <div class="list-group-item {{ $pesanan->status === 'Selesai' ? 'active' : '' }}">
                            <i class="fas fa-check-circle me-2"></i> Selesai
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.list-group-item {
    border-left: 3px solid transparent;
}

.list-group-item.active {
    background-color: #f8f9fa;
    border-left-color: #0d6efd;
    color: #0d6efd;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5em 1em;
}

.text-muted {
    color: #6c757d !important;
}

.badge.bg-success {
    background-color: #198754 !important;
}

.badge.bg-danger {
    background-color: #dc3545 !important;
}

.badge {
    font-weight: 500;
    padding: 0.5em 0.8em;
}
</style>
@endsection 