@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Manajemen Pesanan Produk</h2>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Pesanan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pesananproduk.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="search" class="form-label">Cari Pesanan</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Cari nama pemesan, produk, atau ID pesanan...">
                </div>
                
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Dikonfirmasi" {{ request('status') == 'Dikonfirmasi' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Dibatalkan" {{ request('status') == 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="ekspedisi" class="form-label">Ekspedisi</label>
                    <select class="form-select" id="ekspedisi" name="ekspedisi">
                        <option value="">Semua Ekspedisi</option>
                        <option value="JNE" {{ request('ekspedisi') == 'JNE' ? 'selected' : '' }}>JNE</option>
                        <option value="J&T" {{ request('ekspedisi') == 'J&T' ? 'selected' : '' }}>J&T</option>
                        <option value="SiCepat" {{ request('ekspedisi') == 'SiCepat' ? 'selected' : '' }}>SiCepat</option>
                        <option value="Pos Indonesia" {{ request('ekspedisi') == 'Pos Indonesia' ? 'selected' : '' }}>Pos Indonesia</option>
                        <option value="TIKI" {{ request('ekspedisi') == 'TIKI' ? 'selected' : '' }}>TIKI</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary d-block w-100">
                        <i class="fas fa-search me-2"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Produk</th>
                            <th>Ekspedisi</th>
                            <th>Status</th>
                            <th>Tanggal Pesan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $item)
                            <tr>
                                <td>{{ $item->id_pesanan }}</td>
                                <td>{{ $item->nama_pemesan }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->ekspedisi ?: '-' }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status === 'Menunggu') bg-warning
                                        @elseif($item->status === 'Dikonfirmasi') bg-info
                                        @elseif($item->status === 'Selesai') bg-success
                                        @else bg-danger
                                        @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pesananproduk.edit', $item->id_pesanan) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data pesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 