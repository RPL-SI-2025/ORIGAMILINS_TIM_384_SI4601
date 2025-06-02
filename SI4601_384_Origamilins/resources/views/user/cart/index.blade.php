<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }
        .cart-container {
            max-width: 1200px;
            margin: 80px auto 0 auto;
            padding: 24px;
        }
        .cart-header {
            font-size: 1.5rem;
            font-weight: 700;
            color: #22223b;
            margin-bottom: 32px;
            text-align: center;
        }
        .cart-item {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            padding: 18px 20px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 18px;
        }
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 10px;
            object-fit: cover;
            background: #f0f0f0;
            border: 1px solid #eee;
        }
        .product-info {
            flex: 1 1 0;
            min-width: 0;
        }
        .product-info h6 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #22223b;
            margin-bottom: 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .product-category {
            background: #e3f2fd;
            color: #126ffb;
            padding: 2px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 6px;
        }
        .product-price {
            font-size: 1rem;
            font-weight: 700;
            color: #126ffb;
            margin-bottom: 6px;
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 8px;
        }
        .quantity-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #f3f4f6;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: #126ffb;
            transition: background 0.2s, color 0.2s;
        }
        .quantity-btn:disabled {
            color: #bbb;
            background: #f3f4f6;
            cursor: not-allowed;
        }
        .quantity-btn:hover:not(:disabled) {
            background: #e0e7ff;
            color: #22223b;
        }
        .quantity-input {
            width: 36px;
            text-align: center;
            border: none;
            font-weight: 600;
            background: transparent;
            font-size: 1rem;
            color: #22223b;
        }
        .delete-btn {
            width: 32px;
            height: 32px;
            border: none;
            background: #ffeaea;
            color: #ef4444;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            margin-left: 8px;
            transition: background 0.2s, color 0.2s;
        }
        .delete-btn:hover {
            background: #ef4444;
            color: #fff;
        }
        .summary-section {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
            font-size: 1rem;
        }
        .summary-row.total {
            font-size: 1.1rem;
            font-weight: 700;
            color: #22223b;
            padding-top: 12px;
            border-top: 1px solid #eee;
            margin-top: 12px;
            margin-bottom: 0;
        }
        .checkout-btn {
            width: 100%;
            background: #ffc107;
            border: none;
            color: #22223b;
            font-weight: 700;
            padding: 15px;
            border-radius: 10px;
            font-size: 1.1rem;
            margin-top: 22px;
            transition: background 0.2s, color 0.2s;
        }
        .checkout-btn:hover {
            background: #ffb300;
            color: #22223b;
        }
        .back-btn {
            background: none;
            border: none;
            color: #666;
            font-size: 1rem;
            margin-bottom: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .back-btn:hover {
            color: #22223b;
        }
        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }
        .empty-cart i {
            font-size: 48px;
            margin-bottom: 16px;
            color: #ccc;
        }
        @media (max-width: 600px) {
            .cart-container { max-width: 100%; padding: 12px 0 32px 0;}
            .cart-item { flex-direction: column; align-items: flex-start; gap: 10px; padding: 14px 10px;}
            .summary-section { padding: 18px 10px; }
        }
    </style>
</head>
<body>
    @include('user.navigation-menu')
    <div class="cart-container">
        <button class="back-btn" onclick="window.location.href='{{ route('etalase') }}'">
            <i class="fas fa-arrow-left"></i> Kembali ke Katalog
        </button>
        <h1 class="cart-header">Keranjang Saya</h1>

        @if($items->isEmpty())
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <div>Keranjang Anda masih kosong.</div>
                <a href="{{ route('etalase') }}" class="btn btn-primary mt-3">Belanja Sekarang</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-7">
                    @foreach($items as $item)
                    <div class="cart-item">
                        <img src="{{ asset($item->produk->gambar) }}"
                             alt="{{ $item->produk->nama }}"
                             class="product-image"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/80x80?text=No+Image';">
                        <div class="product-info">
                            <h6 title="{{ $item->produk->nama }}">{{ $item->produk->nama }}</h6>
                            <span class="product-category">{{ $item->produk->kategori ?? '' }}</span>
                            <div class="product-price">Rp {{ number_format($item->produk->harga,0,',','.') }}</div>
                        </div>
                        <div>
                            <div class="quantity-controls">
                                <!-- Kurangi -->
                                <form action="{{ route('cart.update') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="{{ $item->jumlah - 1 }}">
                                    <button type="submit" class="quantity-btn" {{ $item->jumlah <= 1 ? 'disabled' : '' }} title="Kurangi">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </form>
                                <span class="quantity-input">{{ $item->jumlah }}</span>
                                <!-- Tambah -->
                                <form action="{{ route('cart.update') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                    <button type="submit" class="quantity-btn" title="Tambah">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </form>
                                <!-- Hapus -->
                                <form action="{{ route('cart.delete') }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <button type="submit" class="delete-btn" title="Hapus" dusk="btn-hapus-produk-{{ $item->produk->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="col-md-5">
                    <!-- Summary Section -->
                    <div class="summary-section">
                        <div class="summary-row">
                            <span>Subtotal</span>
                            <span id="subtotal">Rp{{ number_format($total,0,',','.') }}</span>
                        </div>
                        <div class="summary-row total">
                            <span>Total</span>
                            <span id="total">Rp{{ number_format($total,0,',','.') }}</span>
                        </div>
                        <a href="{{ route('user.payments.create') }}" class="checkout-btn text-center d-block" style="text-decoration:none;">
                            Lanjut Ke Pembayaran
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>

