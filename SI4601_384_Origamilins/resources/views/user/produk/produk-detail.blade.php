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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" />

    <style>
        body { 
            background-color: #f8f9fa; 
            font-family: 'Figtree', sans-serif;
        }
        
        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .brand-logo {
            height: 35px;
            width: auto;
        }
        
        .brand-text {
            margin: 0;
            color: #0835d8;
            font-weight: 600;
            font-size: 1.5rem;
        }
        
        .main-content {
            min-height: calc(100vh - 200px);
            padding: 20px 0;
        }
        
        .nav-link {
            color: #6c757d !important;
            font-weight: 500;
        }
        
        .nav-link:hover {
            color: #0835d8 !important;
        }
        
        .nav-link.active {
            color: #0835d8 !important;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: #0835d8;
            border-color: #0835d8;
        }
        
        .btn-primary:hover {
            background-color: #0629a8;
            border-color: #0629a8;
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
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" class="brand-logo">
                <span class="brand-text">Origamilins</span>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-home me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('etalase') ? 'active' : '' }}" href="{{ route('etalase') }}">
                            <i class="fas fa-store me-1"></i> Etalase Produk
                        </a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pesananproduk.*') ? 'active' : '' }}" href="{{ route('pesananproduk.index') }}">
                            <i class="fas fa-shopping-cart me-1"></i> Pesanan Saya
                        </a>
                    </li>
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profile.create') }}">
                                    <i class="fas fa-user me-2"></i> Profil
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="{{ route('logout') }}">
                                    <i class="fas fa-sign-out-alt me-2"></i> Logout
                                </a></li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="fas fa-sign-in-alt me-1"></i> Login
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="container">
            <div class="row">
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
                <div class="col-md-6">
                    <div class="product-details">
                        <h1 class="product-title">{{ $produk->nama }}</h1>
                        <div class="d-flex align-items-center mb-3">
                            <span class="text-muted me-2">Hubungi Kami</span>
                            <a href="https://wa.me/{{ $produk->kontak_wa ?? '' }}" class="text-success me-2" target="_blank"><i class="fab fa-whatsapp fa-lg"></i></a>
                            <a href="{{ $produk->link_ig ?? '#' }}" class="text-danger" target="_blank"><i class="fab fa-instagram fa-lg"></i></a>
                        </div>
                        <div class="text-muted mb-3">
                            <span class="me-3">{{ $produk->likes_count ?? 0 }} Disukai</span> | 
                            <span>{{ $produk->reviews_count ?? 0 }} Komentar</span>
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
                            <form action="{{ route('cart.add') }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="number" name="jumlah" value="1" min="1" class="form-control" style="width: 100px">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-cart-plus me-2"></i>Tambahkan ke Keranjang
                                </button>
                            <form id="buy-now-form" action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="jumlah" id="buy-now-qty" value="1">
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-money-bill me-2"></i>Beli Sekarang
                                </button>
                            </form>
                            </form>
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
    <footer class="bg-white border-top py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="navbar-brand">
                        <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" class="brand-logo">
                        <span class="brand-text">Origamilins</span>
                    </div>
                    <p class="text-muted mt-2">Platform jual beli produk origami berkualitas</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">&copy; {{ date('Y') }} Origamilins. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 