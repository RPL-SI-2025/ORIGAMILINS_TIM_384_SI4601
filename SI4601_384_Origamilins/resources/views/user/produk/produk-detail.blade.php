<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $produk->nama }} - Origamilins</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

    <style>
        body, h1, h2, h3, h4, h5, h6, .navbar, .btn, .form-control, .product-title, .product-category, .product-price, .product-stock, .filter-sidebar, .page-title, .pagination, .no-products {
            font-family: 'Poppins', Arial, sans-serif !important;
        }
        .main-content {
            padding-top: 80px; /* Lebih rapat ke navbar */
        }

        .product-image {
            width: 100%;
            max-height: 500px;
            object-fit: contain;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-details {
            background-color: white;
            border-radius: 8px;
            padding: 2rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .product-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #0835d8;
            margin-bottom: 1rem;
        }

        .product-category {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 1rem;
        }

        .product-description {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .related-products {
            margin-top: 3rem;
        }

        .related-product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .related-product-card:hover {
            transform: translateY(-5px);
        }

        .related-product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .review-section {
            margin-top: 3rem;
        }

        .review-card {
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .review-header {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .review-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .review-author {
            font-weight: 600;
            color: #333;
        }

        .review-date {
            font-size: 0.875rem;
            color: #6c757d;
        }

        .review-content {
            color: #666;
            line-height: 1.6;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    @include('user.navigation-menu')

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row">
            <div class="container py-4">
                <a href="{{ route('etalase') }}" class="btn btn-outline-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>
                <!-- Product Image -->
                <div class="col-md-6 mb-4">
                    @if($produk->gambar)
                        <img src="{{ asset($produk->gambar) }}" alt="{{ $produk->nama }}" class="product-image">
                    @else
                        <div class="product-image d-flex align-items-center justify-content-center bg-light">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                </div>

                <!-- Product Details -->
                <div class="col-md-6 mb-4">
                    <div class="product-details">
                        <h1 class="product-title">{{ $produk->nama }}</h1>
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-muted me-2">Hubungi Kami</span>
                            <a href="https://l.instagram.com/?u=http%3A%2F%2Fwa.me%2F628111580800%3Ffbclid%3DPAZXh0bgNhZW0CMTEAAadUZqIwtGzWSyQnt97K2aTh6__cWblkxx6ZK5dY2BnPAP56yZSzD70C6APz3g_aem_oYzIP_yEj6-aH2x1MLCWjA&e=AT0qcpM0W_QNA1HJb7WIiXoT4Atqb26L1z2LsRbcm6V4tk22DgVelM7rOLC0Ovs5l-3_FDWHymfM6g-o6ANo1jN8eUy2OhCRCgVBHQ"
                            class="text-success me-2" target="_blank">
                                <i class="fab fa-whatsapp fa-lg"></i>
                            </a>
                            <a href="https://www.instagram.com/klub.origami.indonesia?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw=="
                            class="text-danger" target="_blank">
                                <i class="fab fa-instagram fa-lg"></i>
                            </a>
                        </div>
                        <div class="text-muted mb-3">
                            <span>{{ $ulasan->count() }} Komentar</span>
                            @if($produk->is_pre_order ?? false)
                                <span class="badge bg-warning ms-2">Pre-Order</span>
                            @endif
                        </div>
                        <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                        <div class="product-category">
                            <i class="fas fa-tag me-2"></i>{{ $produk->kategori }}
                        </div>
                        <div class="product-description">
                            {{ $produk->deskripsi }}
                        </div>

                        @if($produk->waktu_pre_order ?? false)
                            <div class="mb-3 text-muted">Pre-Order {{ $produk->waktu_pre_order }} hari.</div>
                        @endif
                        @if($produk->info_pengiriman ?? false)
                            <div class="mb-3 text-muted">Pengiriman akan dilakukan setelah proses pembuatan selesai.</div>
                        @endif

                        @if(!empty($produk->jenis))
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <div>
                                    @foreach(json_decode($produk->jenis) as $jenis)
                                        <button type="button" class="btn btn-outline-primary btn-sm me-2 mb-2">{{ $jenis }}</button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @auth
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center" id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="number" name="jumlah" value="1" min="1" class="form-control me-2" style="width: 80px" id="qty-input">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-2"></i>Tambahkan ke Keranjang
                                </button>
                            </form>
                            <form action="{{ route('cart.add') }}" method="POST" id="buy-now-form">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="jumlah" id="buy-now-qty" value="1">
                                <input type="hidden" name="redirect_to_cart" value="1">
                                <button type="submit" class="btn btn-warning ms-2">
                                    <i class="fas fa-money-bill me-2"></i>Beli Sekarang
                                </button>
                            </form>
                        </div>
                        <script>
                            // Sinkronkan jumlah pada "Beli Sekarang" dengan input jumlah utama
                            document.getElementById('qty-input').addEventListener('input', function() {
                                document.getElementById('buy-now-qty').value = this.value;
                            });
                        </script>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Login untuk Membeli
                        </a>
                    @endauth
                    </div>
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="review-section">
                <h3 class="mb-4">Ulasan Produk</h3>
                @forelse($ulasan as $review)
                    <div class="review-card">
                        <div class="review-header">
                            <img src="{{ $review->user->profile_photo_url ?? asset('images/default-avatar.png') }}" 
                                 alt="{{ $review->user->name }}" 
                                 class="review-avatar">
                            <div>
                                <div class="review-author">{{ $review->user->name }}</div>
                                <div class="review-date">{{ $review->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </div>
                        <div class="review-content">
                            {{ $review->komentar }}
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada ulasan untuk produk ini</p>
                    </div>
                @endforelse
            </div>

            <!-- Related Products -->
            @if($produkTerkait->count() > 0)
                <div class="related-products">
                    <h3 class="mb-4">Produk Terkait</h3>
                    <div class="row">
                        @foreach($produkTerkait as $related)
                            <div class="col-md-3 mb-4">
                                <a href="{{ route('detail.produk', $related->id) }}" class="text-decoration-none">
                                    <div class="related-product-card">
                                        @if($related->gambar)
                                            <img src="{{ asset($related->gambar) }}" 
                                                 alt="{{ $related->nama }}" 
                                                 class="related-product-image">
                                        @else
                                            <div class="related-product-image d-flex align-items-center justify-content-center bg-light">
                                                <i class="fas fa-image fa-2x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="p-3">
                                            <h5 class="text-dark mb-2">{{ $related->nama }}</h5>
                                            <p class="text-primary mb-0">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </main>
    <!-- Footer -->
     @include('user.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbarCollapse = document.getElementById('navbarContent');
        if (navbarCollapse) {
            // Remove the 'collapse' class and add 'show' class
            navbarCollapse.classList.remove('collapse');
            navbarCollapse.classList.add('show');
            // Ensure the display is not 'none' in case of conflicting CSS
            navbarCollapse.style.display = 'block';
        }
    });
    </script>
</body>
</html>