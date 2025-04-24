@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Detail Ulasan Produk</h2>
        <a href="{{ route('admin.product-reviews.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Ulasan</h5>
                    
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Produk</div>
                        <div class="col-md-9">
                            <a href="{{ route('admin.produk.show', $review->produk) }}">
                                {{ $review->produk->nama }}
                            </a>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Pengguna</div>
                        <div class="col-md-9">
                            @if($review->user)
                                {{ $review->user->name }}
                            @else
                                <span class="text-muted">(User tidak tersedia)</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Rating</div>
                        <div class="col-md-9">
                            <div class="text-warning">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $review->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Komentar</div>
                        <div class="col-md-9">
                            @if($review->komentar)
                                {{ $review->komentar }}
                            @else
                                <span class="text-muted">(Tidak ada komentar)</span>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status</div>
                        <div class="col-md-9">
                            @switch($review->status)
                                @case('pending')
                                    <span class="badge bg-warning">Menunggu</span>
                                    @break
                                @case('approved')
                                    <span class="badge bg-success">Disetujui</span>
                                    @break
                                @case('rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Tanggal</div>
                        <div class="col-md-9">
                            {{ $review->created_at->format('d M Y H:i') }}
                        </div>
                    </div>

                    @if($review->status === 'pending')
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="d-flex gap-2">
                                    <form action="{{ route('admin.product-reviews.approve', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-check"></i> Setujui Ulasan
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.product-reviews.reject', $review) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-times"></i> Tolak Ulasan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Informasi Produk</h5>
                    
                    <div class="text-center mb-3">
                        @if($review->produk->gambar)
                            <img src="{{ asset($review->produk->gambar) }}" alt="{{ $review->produk->nama }}" class="img-fluid rounded" style="max-height: 200px;">
                        @else
                            <div class="bg-light rounded p-5 text-center">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2 text-muted">Tidak ada gambar</p>
                            </div>
                        @endif
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Kategori</div>
                        <div class="col-md-8">{{ $review->produk->kategori }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Harga</div>
                        <div class="col-md-8">Rp {{ number_format($review->produk->harga, 0, ',', '.') }}</div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 fw-bold">Stok</div>
                        <div class="col-md-8">{{ $review->produk->stok }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .text-warning {
        color: #ffc107 !important;
    }
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .card-title {
        color: #333;
        font-weight: 600;
    }
    .badge {
        font-size: 0.9rem;
        padding: 0.5em 0.8em;
    }
</style>
@endpush
@endsection 