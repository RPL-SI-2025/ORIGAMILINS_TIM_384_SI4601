 <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
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
    @include('user.navigation-menu')
    <div class="cart-container">
        <button class="back-btn" onclick="window.location.href='{{ route('etalase') }}'">
            <i class="fas fa-arrow-left"></i>
        </button>
        <h1 class="cart-header">Tambah ke keranjang</h1>

        @if($items->isEmpty())
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <div>Keranjang Anda masih kosong.</div>
                <a href="{{ route('etalase') }}" class="btn btn-primary mt-3">Belanja Sekarang</a>
            </div>
        @else
            @foreach($items as $item)
            <div class="cart-item">
                <div class="row align-items-center">
                    <div class="col-3">
                        <img src="{{ $item->produk->gambar_url ?? 'https://via.placeholder.com/80' }}" 
                            alt="{{ $item->produk->nama }}" class="product-image">
                    </div>
                    <div class="col-6">
                        <div class="product-info">
                            <h6>{{ $item->produk->nama }}</h6>
                            <div class="product-specs">{{ $item->produk->spesifikasi ?? '' }}</div>
                            <span class="product-category">{{ $item->produk->kategori ?? '' }}</span>
                        </div>
                    </div>
                    <div class="col-3 text-end">
                        <div class="product-price mb-2">Rp {{ number_format($item->produk->harga,0,',','.') }}</div>
                        <div class="quantity-controls">
                            <!-- Kurangi -->
                            <form action="{{ route('cart.update') }}" method="POST" style="display:inline-flex;">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" value="{{ $item->jumlah - 1 }}">
                                <button type="submit" class="quantity-btn" {{ $item->jumlah <= 1 ? 'disabled' : '' }}>
                                    <i class="fas fa-minus"></i>
                                </button>
                            </form>
                            <span class="quantity-input">{{ $item->jumlah }}</span>
                            <!-- Tambah -->
                            <form action="{{ route('cart.update') }}" method="POST" style="display:inline-flex;">
                                @csrf
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <input type="hidden" name="jumlah" value="{{ $item->jumlah + 1 }}">
                                <button type="submit" class="quantity-btn">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </form>
                            <!-- Hapus -->
                            <form action="{{ route('cart.delete') }}" method="POST" style="display:inline-flex; margin-left:8px;">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="item_id" value="{{ $item->id }}">
                                <button type="submit" class="btn btn-danger btn-sm d-flex align-items-center justify-content-center" 
                                    title="Hapus" dusk="btn-hapus-produk-{{ $item->produk->id }}" style="width:32px;height:32px;padding:0;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

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
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let quantity = 1;
        const basePrice = 1200000;
        const shippingCost = 40000;
        
        function updatePrices() {
            const subtotal = basePrice * quantity;
            const total = subtotal; // tanpa ongkir
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
    @include('footer')
</body>
</html>

