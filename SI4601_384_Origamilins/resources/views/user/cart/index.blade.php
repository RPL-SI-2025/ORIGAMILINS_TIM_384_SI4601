include('user.navigation-menu')
@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('etalase') }}" class="btn btn-outline-secondary mb-3"><i class="fas fa-arrow-left me-2"></i>Kembali</a>
    <h1 class="mb-4">Keranjang Saya</h1>
    @if (isset($message) && $message == 'Keranjang Anda masih kosong')
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-shopping-cart fa-2x mb-3"></i><br>
            {{ $message }}
            <br><br>
            <a href="{{ route('etalase') }}" class="btn btn-primary">Mulai Belanja</a>
        </div>
    @else
        <form id="checkout-form" method="POST" action="{{ route('cart.checkout') }}">
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="d-flex align-items-center mb-3">
                        <input type="checkbox" id="select-all-cart" class="form-check-input me-2" />
                        <label for="select-all-cart" class="mb-0">Pilih Semua</label>
                    </div>
                    @foreach ($cartItems as $item)
                    <div class="bg-white rounded-4 p-4 mb-4 shadow-sm cart-item-row">
                        <div class="row align-items-center">
                            <div class="col-1 text-center">
                                <input type="checkbox" class="form-check-input cart-item-checkbox" name="item_ids[]" value="{{ $item->id }}" checked data-subtotal="{{ $item->subtotal }}" />
                            </div>
                            <div class="col-12 col-md-2 text-center mb-3 mb-md-0">
                                @if($item->produk->gambar)
                                    <img src="{{ filter_var($item->produk->gambar, FILTER_VALIDATE_URL) ? $item->produk->gambar : asset($item->produk->gambar) }}" 
                                         class="img-fluid rounded-3" alt="{{ $item->produk->nama }}" style="max-height: 120px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center rounded-3" style="height: 120px;">
                                        <i class="fas fa-image fa-2x text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-12 col-md-6">
                                <h5 class="mb-1">{{ $item->produk->nama }}</h5>
                                <span class="badge bg-primary mb-1">{{ $item->produk->kategori ?? '-' }}</span>
                                <div class="mb-1 text-muted" style="font-size: 0.95em;">Harga: <b>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</b></div>
                                <div class="mb-1 text-muted subtotal-produk" style="font-size: 0.95em;">Subtotal: <b>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</b></div>
                            </div>
                            <div class="col-12 col-md-3 text-center mt-3 mt-md-0">
                                <div class="d-flex flex-row flex-md-column align-items-center justify-content-center gap-2">
                                    <input type="number" min="1" value="{{ $item->jumlah }}"
                                        data-produk-id="{{ $item->produk_id }}"
                                        class="form-control update-quantity text-center form-control-sm"
                                        style="width: 60px" />
                                    <button class="btn btn-outline-danger btn-sm remove-produk" data-produk-id="{{ $item->produk_id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .cart-container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .cart-header {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 25px;
        }
        
        .cart-item {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background: #f0f0f0;
        }
        
        .product-info h6 {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }
        
        .product-specs {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }
        
        .product-category {
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        
        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .quantity-btn {
            width: 32px;
            height: 32px;
            border: 1px solid #ddd;
            background: white;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }
        
        .quantity-btn:hover {
            background: #f5f5f5;
            border-color: #ccc;
        }
        
        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            font-weight: 600;
            background: transparent;
        }
        
        .quantity-input:focus {
            outline: none;
        }
        
        .summary-section {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-top: 30px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }
        
        .summary-row.total {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            padding-top: 12px;
            border-top: 1px solid #eee;
            margin-top: 12px;
            margin-bottom: 0;
        }
        
        .delivery-info {
            color: #666;
            font-size: 12px;
            margin-top: 8px;
        }
        
        .checkout-btn {
            width: 100%;
            background: #ffc107;
            border: none;
            color: #333;
            font-weight: 600;
            padding: 14px;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 20px;
            transition: all 0.2s;
        }
        
        .checkout-btn:hover {
            background: #ffb300;
            color: #333;
        }
        
        .back-btn {
            background: none;
            border: none;
            color: #666;
            font-size: 16px;
            margin-bottom: 10px;
            cursor: pointer;
        }
        
        .back-btn:hover {
            color: #333;
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
    </style>
</head>
<body>
    <div class="cart-container">
        <button class="back-btn">
            <i class="fas fa-arrow-left"></i>
        </button>
        
        <h1 class="cart-header">Tambah ke keranjang</h1>
        
        <!-- Cart Item -->
        <div class="cart-item">
            <div class="row align-items-center">
                <div class="col-3">
                    <img src="https://images.unsplash.com/photo-1586023492125-27b2c045efd7?w=200&h=200&fit=crop" 
                         alt="Hiasan Gantung" class="product-image">
                </div>
                <div class="col-6">
                    <div class="product-info">
                        <h6>Hiasan Gantung</h6>
                        <div class="product-specs">1x2 m</div>
                        <span class="product-category">Batal</span>
                    </div>
                </div>
                <div class="col-3 text-end">
                    <div class="product-price mb-2">Rp 1.200.000</div>
                    <div class="quantity-controls">
                        <button class="quantity-btn" onclick="decreaseQuantity()">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="text" class="quantity-input" value="1" id="quantity">
                        <button class="quantity-btn" onclick="increaseQuantity()">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summary Section -->
        <div class="summary-section">
            <div class="summary-row">
                <span>Subtotal</span>
                <span id="subtotal">Rp1.200.000</span>
            </div>
            <div class="summary-row">
                <span>Estimasi Ongkos Kirim</span>
                <span>Rp40.000</span>
            </div>
            <div class="summary-row total">
                <span>Total</span>
                <span id="total">Rp1.240.000</span>
            </div>
            <div class="delivery-info">Estimasi pengiriman 1 hari</div>
            
            <button class="checkout-btn">
                Lanjut Ke Pembayaran
            </button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let quantity = 1;
        const basePrice = 1200000;
        const shippingCost = 40000;
        
        function updatePrices() {
            const subtotal = basePrice * quantity;
            const total = subtotal + shippingCost;
            
            document.getElementById('subtotal').textContent = 'Rp' + subtotal.toLocaleString('id-ID');
            document.getElementById('total').textContent = 'Rp' + total.toLocaleString('id-ID');
            document.getElementById('quantity').value = quantity;
        }
        
        function increaseQuantity() {
            quantity++;
            updatePrices();
        }
        
        function decreaseQuantity() {
            if (quantity > 1) {
                quantity--;
                updatePrices();
            }
        }
        
        // Handle manual quantity input
        document.getElementById('quantity').addEventListener('change', function() {
            const newQuantity = parseInt(this.value);
            if (newQuantity >= 1) {
                quantity = newQuantity;
                updatePrices();
            } else {
                this.value = quantity;
            }
        });

        $('.subtotal-cart, .total-cart').text('Rp ' + total.toLocaleString('id-ID'));
    }
    $('#select-all-cart, .cart-item-checkbox').on('change', function() {
        updateSummaryByChecked();
        toggleCheckoutButton();
    });
    // Inisialisasi saat load
    updateSummaryByChecked();
});
</script>
@endpush

        
        // Back button functionality
        document.querySelector('.back-btn').addEventListener('click', function() {
            // In real implementation, this would navigate back
            console.log('Navigating back to etalase');
        });
        
        // Checkout button functionality
        document.querySelector('.checkout-btn').addEventListener('click', function() {
            // In real implementation, this would proceed to checkout
            console.log('Proceeding to checkout with quantity:', quantity);
        });
    </script>
</body>
</html>

