@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Statistik Produk -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Manajemen Produk
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Total: {{ \App\Models\Produk::count() }}
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.produk.index') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-box me-1"></i> Kelola Produk
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Statistik Event -->
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Manajemen Event
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                Total: {{ \App\Models\Event::count() }}
                            </div>
                            <div class="mt-3">
                                <a href="{{ route('admin.event.index') }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-calendar me-1"></i> Kelola Event
                                </a>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Aktivitas Terbaru</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Produk Terbaru -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Produk Terbaru</h6>
                            <div class="list-group list-group-flush">
                                @forelse(\App\Models\Produk::latest()->take(5)->get() as $produk)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $produk->nama_produk }}</h6>
                                            <small class="text-muted">Rp {{ number_format($produk->harga, 0, ',', '.') }}</small>
                                        </div>
                                        <p class="mb-1 text-muted small">{{ Str::limit($produk->deskripsi, 50) }}</p>
                                        <small class="text-muted">Stok: {{ $produk->stok }}</small>
                                    </div>
                                @empty
                                    <div class="list-group-item">Tidak ada produk</div>
                                @endforelse
                            </div>
                        </div>

                        <!-- Event Terbaru -->
                        <div class="col-md-6">
                            <h6 class="border-bottom pb-2">Event Terbaru</h6>
                            <div class="list-group list-group-flush">
                                @forelse(\App\Models\Event::latest()->take(5)->get() as $event)
                                    <div class="list-group-item">
                                        <div class="d-flex w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $event->nama_event }}</h6>
                                            <small class="text-muted">{{ date('d M Y', strtotime($event->tanggal_pelaksanaan)) }}</small>
                                        </div>
                                        <p class="mb-1 text-muted small">{{ Str::limit($event->deskripsi, 50) }}</p>
                                    </div>
                                @empty
                                    <div class="list-group-item">Tidak ada event</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #0835d8;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a;
    }
    .text-xs {
        font-size: 0.7rem;
    }
    .text-gray-300 {
        color: #dddfeb;
    }
    .text-gray-800 {
        color: #5a5c69;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
</style>
@endsection 