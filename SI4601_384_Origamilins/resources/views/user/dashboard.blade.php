@extends('user.app')
@section('content')
    <!-- Etalase Produk -->
    <div id="etalase" class="card">
        <div class="card-header">
            <h5 class="mb-0">Etalase Produk</h5>
        </div>
        <div class="card-body">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($products as $product)
                    <div class="col">
                        <div class="card h-100 product-card">
                            @if($product->gambar)
                                @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                                    <img src="{{ $product->gambar }}" class="card-img-top" alt="{{ $product->nama }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <img src="{{ asset($product->gambar) }}" class="card-img-top" alt="{{ $product->nama }}" style="height: 200px; object-fit: cover;">
                                @endif
                            @else
                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->nama }}</h5>
                                <p class="card-text text-primary fw-bold">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                <p class="card-text">
                                    <small class="text-muted">{{ $product->kategori }}</small>
                                </p>
                                <a href="{{ route('admin.produk.show', $product->id) }}" class="btn btn-primary w-100">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="h5 text-muted">Belum ada produk yang tersedia</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    Menampilkan {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} dari {{ $products->total() ?? 0 }} produk
                </div>
                <div>
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .dashboard-stat-card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
        border-radius: 0.75rem;
    }
    .stat-card-body {
        padding: 1.5rem 1.25rem;
    }
    .icon-circle {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f8f9fa;
        font-size: 1.5rem;
    }
    .product-card {
        transition: transform 0.2s;
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border-radius: 0.75rem;
    }
    .product-card:hover {
        transform: translateY(-5px);
    }
    .card-img-top {
        border-top-left-radius: 0.75rem;
        border-top-right-radius: 0.75rem;
    }
    .btn-primary {
        background-color: #0835d8;
        border-color: #0835d8;
    }
    .btn-primary:hover {
        background-color: #0629b0;
        border-color: #0629b0;
    }
    .pagination {
        margin-bottom: 0;
    }
    .page-link {
        color: #0835d8;
    }
    .page-item.active .page-link {
        background-color: #0835d8;
        border-color: #0835d8;
    }
</style>
@endpush
