@extends('user.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Detail Pesanan #{{ $pesanan->id_pesanan }}</h4>
                        <a href="{{ route('user.pesanan.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Status Pesanan -->
                    <div class="mb-4">
                        <h5 class="card-title">Status Pesanan</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge {{ $pesanan->status_badge }} me-2">{{ $pesanan->status }}</span>
                            @if($pesanan->pengrajin)
                                <span class="badge bg-info">Pengrajin: {{ $pesanan->pengrajin->nama }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Detail Produk -->
                    <div class="mb-4">
                        <h5 class="card-title">Detail Produk</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Nama Produk</th>
                                    <td>{{ $pesanan->produk->nama_produk }}</td>
                                </tr>
                                <tr>
                                    <th>Jumlah</th>
                                    <td>{{ $pesanan->jumlah }} unit</td>
                                </tr>
                                <tr>
                                    <th>Total Harga</th>
                                    <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="mb-4">
                        <h5 class="card-title">Status Pembayaran</h5>
                        <div class="d-flex align-items-center">
                            <span class="badge {{ $pesanan->status_pembayaran === 'Paid' ? 'bg-success' : 'bg-danger' }}">
                                {{ $pesanan->status_pembayaran === 'Paid' ? 'Lunas' : 'Belum Lunas' }}
                            </span>
                            @if($pesanan->status_pembayaran === 'Paid')
                                <span class="ms-2 text-muted">
                                    Dibayar pada: {{ $pesanan->tanggal_pembayaran ? $pesanan->tanggal_pembayaran->format('d/m/Y H:i') : '-' }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Informasi Pengiriman -->
                    @if($pesanan->status === 'Dikirim')
                    <div class="mb-4">
                        <h5 class="card-title">Informasi Pengiriman</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>Ekspedisi</th>
                                    <td>{{ $pesanan->ekspedisi }}</td>
                                </tr>
                                <tr>
                                    <th>Nomor Resi</th>
                                    <td>{{ $pesanan->nomor_resi }}</td>
                                </tr>
                                <tr>
                                    <th>Alamat Pengiriman</th>
                                    <td>{{ $pesanan->alamat_pengiriman }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    @endif

                    <!-- Timeline Status -->
                    <div class="mb-4">
                        <h5 class="card-title">Timeline Status</h5>
                        <div class="list-group">
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

                    <!-- Catatan -->
                    @if($pesanan->catatan)
                    <div class="mb-4">
                        <h5 class="card-title">Catatan</h5>
                        <p class="mb-0">{{ $pesanan->catatan }}</p>
                    </div>
                    @endif

                    <!-- Aksi -->
                    @if($pesanan->status === 'Dikirim')
                    <div class="text-center">
                        <form action="{{ route('user.pesanan.selesai', $pesanan->id_pesanan) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> Konfirmasi Pesanan Diterima
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection