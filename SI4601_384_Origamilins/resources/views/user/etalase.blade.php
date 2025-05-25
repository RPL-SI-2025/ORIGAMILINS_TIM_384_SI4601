@extends('user.layouts.etalase')
@section('content')
    <div class="container-fluid px-0">
        <div class="row g-3">
            @forelse($products as $product)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-3">
                    <div class="tokopedia-card h-100 d-flex flex-column position-relative">
                        <div class="tokopedia-img-wrapper mt-3">
                            @if($product->gambar)
                                @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                                    <img src="{{ $product->gambar }}" class="tokopedia-img" alt="{{ $product->nama }}">
                                @else
                                    <img src="{{ asset($product->gambar) }}" class="tokopedia-img" alt="{{ $product->nama }}">
                                @endif
                            @else
                                <div class="tokopedia-img bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="tokopedia-body flex-grow-1 d-flex flex-column justify-content-between p-2">
                            <div>
                                <div class="tokopedia-title mb-1">{{ $product->nama }}</div>
                                <div class="tokopedia-price mb-1">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                                <div class="d-flex align-items-center gap-1 mb-1">
                                    <span class="text-warning" style="font-size:0.95em;"><i class="fas fa-star"></i> Belum ada rating</span>
                                    <span class="text-muted" style="font-size:0.95em;">| 0 terjual</span>
                                </div>
                                <div class="tokopedia-meta small text-muted mb-1">by <span class="fw-semibold" style="color:#0835d8;">Origamilins</span></div>
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('user.produk.detail', $product->id) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i> Lihat Detail
                            </a>
                                <button class="btn btn-primary btn-sm add-to-cart" data-produk-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-cart me-1"></i> Tambah ke Keranjang
                                </button>
                            </div>
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
        <div class="d-flex justify-content-end align-items-center mt-4">
            {{ $products->withQueryString()->links() }}
        </div>
    </div>
    @push('styles')
    <style>
        /* Hilangkan padding admin-content khusus halaman etalase */
        .admin-content { padding: 0 !important; background: none !important; box-shadow: none !important; }
        .tokopedia-card {
            border: 1px solid #eee;
            border-radius: 10px;
            background: #fff;
            transition: box-shadow 0.2s, transform 0.2s;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03);
            overflow: hidden;
            min-height: 320px;
            padding-top: 8px;
        }
        .tokopedia-card:hover {
            box-shadow: 0 4px 16px rgba(8,53,216,0.10);
            transform: translateY(-2px) scale(1.02);
            border-color: #0835d8;
        }
        .tokopedia-img-wrapper {
            width: 100%;
            aspect-ratio: 1/1;
            background: #f7f7f7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .tokopedia-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }
        .tokopedia-title {
            font-size: 1rem;
            font-weight: 500;
            color: #222;
            line-height: 1.2;
            min-height: 2.2em;
        }
        .tokopedia-price {
            color: #007bff;
            font-weight: 700;
            font-size: 1.05rem;
        }
        .tokopedia-meta {
            font-size: 0.85rem;
        }
        .btn-outline-primary {
            border-radius: 6px;
            font-size: 0.95rem;
            padding: 0.35rem 0.5rem;
        }
        @media (max-width: 991px) {
            .col-lg-3 { flex: 0 0 auto; width: 33.33333333%; }
        }
        @media (max-width: 767px) {
            .col-md-4 { flex: 0 0 auto; width: 50%; }
        }
        @media (max-width: 575px) {
            .col-6 { flex: 0 0 auto; width: 100%; }
        }
        .add-to-cart-icon:hover { background: #e6f0ff; }
    </style>
    @endpush
    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup CSRF token for all AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Handle add to cart clicks
        $('.add-to-cart').on('click', function() {
            const produkId = $(this).data('produk-id');
            $.ajax({
                url: '/cart/add',
                method: 'POST',
                data: {
                    produk_id: produkId,
                    jumlah: 1
                },
                success: function(response) {
                    alert(response.message);
                    // Update cart badge in navbar
                    $('#cart-badge').text(response.cartCount);
                    // Optionally refresh the page if needed for other elements
                    // window.location.reload();
                },
                error: function(xhr) {
                    if (xhr.status === 401) {
                        window.location.href = '/login';
                    } else {
                        alert('Terjadi kesalahan saat menambahkan ke keranjang');
                    }
                }
            });
        });
    });
    </script>
    @endpush
@endsection 