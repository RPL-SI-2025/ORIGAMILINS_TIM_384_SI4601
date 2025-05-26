<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 20px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            cursor: pointer;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .discount-badge {
            position: absolute;
            top: 15px;
            left: 15px;
            background: #ff6b35;
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            z-index: 2;
        }

        .product-image {
            width: 100%;
            height: 220px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .no-image {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #999;
        }

        .product-content {
            padding: 1.5rem;
        }

        .product-category {
            font-size: 0.85rem;
            color: #ff6b35;
            font-weight: 500;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .product-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ff6b35;
            margin-bottom: 1rem;
        }

        .product-stats {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            color: #666;
        }

        .product-stats i {
            color: #ffc107;
        }

        .like-count {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-left: auto;
            color: #ff6b35;
        }

        .product-stock {
            margin-top: 0.8rem;
            padding-top: 0.8rem;
            border-top: 1px solid #f0f0f0;
        }

        .text-success {
            color: #198754 !important;
            font-weight: 600;
        }

        .text-danger {
            color: #dc3545 !important;
            font-weight: 600;
        }

        .no-products {
            text-align: center;
            padding: 3rem;
            color: #666;
            font-size: 1.1rem;
            grid-column: 1 / -1;
        }

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    @include('user.navigation-menu')

    <div class="container-fluid">
      <div class="row">
        <!-- DAFTAR PRODUK -->
        <div class="col-md-10">
          <div class="product-grid">
            @forelse ($products as $product)
                <a href="{{ route('detail.produk', $product->id) }}" class="text-decoration-none">
                    <div class="product-card">
                        @if($product->diskon)
                            <div class="discount-badge">{{ $product->diskon }}% off</div>
                        @endif
                        <div class="product-image">
                            @if($product->gambar)
                                <img src="{{ $product->gambar }}" alt="{{ $product->nama }}" loading="lazy" />
                            @else
                                <div class="no-image"><i class="fas fa-image fa-2x text-muted"></i></div>
                            @endif
                        </div>
                        <div class="product-content">
                            <div class="product-category">{{ $product->kategori ?? 'Produk' }}</div>
                            <div class="product-title">{{ $product->nama }}</div>
                            <div class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            @if(isset($product->stok))
                            <div class="product-stock">
                                <small class="text-{{ $product->stok > 0 ? 'success' : 'danger' }}">
                                    {{ $product->stok > 0 ? 'Stok: '.$product->stok : 'Stok Habis' }}
                                </small>
                            </div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <div class="no-products">Tidak ada produk untuk ditampilkan.</div>
            @endforelse
          </div>
          <div class="mt-4">
            {{ $products->links() }}
          </div>
        </div>
        <!-- SIDEBAR FILTER DI KANAN -->
        <div class="col-md-2 mb-4">
          @include('user.produk.filter', ['categories' => $categories])
        </div>
      </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
