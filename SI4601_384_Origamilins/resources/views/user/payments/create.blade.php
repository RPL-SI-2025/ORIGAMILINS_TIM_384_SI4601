<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Order Summary</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .checkout-container {
            max-width: 100vw;
            width: 100vw;
            margin: 0;
            padding: 32px 32px 32px 32px;
        }
        .section-card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 20px;
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .product-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }
        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 16px;
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
        }
        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-left: auto;
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
        }
        .quantity-input {
            width: 50px;
            text-align: center;
            border: none;
            font-weight: 600;
        }
        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-left: 20px;
            min-width: 120px;
            text-align: right;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
            font-size: 14px;
        }
        .summary-row.total {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            padding-top: 12px;
            border-top: 2px solid #eee;
            margin-top: 16px;
        }
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }
        .form-control {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px;
            font-size: 14px;
        }
        .form-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 0.25rem rgba(255, 193, 7, 0.25);
        }
        .phone-input-group {
            display: flex;
            gap: 8px;
        }
        .country-code {
            width: 80px;
            background: #f8f9fa;
        }
        .shipping-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 12px;
            margin-top: 16px;
            font-size: 14px;
            color: #856404;
        }
        .shipping-info i {
            margin-right: 8px;
        }
        .submit-btn {
            width: 100%;
            background: #ffc107;
            border: none;
            color: #333;
            font-weight: 600;
            padding: 16px;
            border-radius: 8px;
            font-size: 16px;
            margin-top: 24px;
            transition: all 0.2s;
        }
        .submit-btn:hover {
            background: #ffb300;
            color: #333;
        }
        .progress-header {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        }
        .back-btn {
            background: none;
            border: none;
            color: #666;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
            cursor: pointer;
            padding: 0;
        }
        .back-btn:hover {
            color: #333;
        }
        .progress-steps {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 24px;
            margin-top: 16px;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            position: relative;
        }
        .step-circle {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }
        .step-item.active .step-circle {
            background: #ffc107;
            color: #333;
        }
        .step-item.active .step-text {
            color: #ffc107;
            font-weight: 600;
        }
        .step-item.completed .step-circle {
            background: #28a745;
            color: white;
        }
        .step-item.completed .step-text {
            color: #28a745;
        }
        .step-item:not(.active):not(.completed) .step-circle {
            background: #e9ecef;
            color: #6c757d;
        }
        .step-item:not(.active):not(.completed) .step-text {
            color: #6c757d;
        }
        .step-connector {
            width: 40px;
            height: 2px;
            background: #e9ecef;
            margin: 0 12px;
        }
        .step-connector.completed {
            background: #28a745;
        }
        .shipping-terms {
            padding: 20px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-top: 20px;
        }
        .shipping-terms h6 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 12px;
        }
        .shipping-terms ul {
            list-style: disc;
            padding: 0;
            margin: 0;
        }
        .shipping-terms li {
            padding: 6px 0;
            font-size: 14px;
            color: #666;
        }
        .shipping-terms li i {
            color: #28a745;
            margin-right: 8px;
        }
    </style>
</head>
<body>
    @include('user.navigation-menu ')
    <div class="checkout-container">
        <!-- Progress Header -->
        <div class="progress-header">
            <button class="back-btn" onclick="goBack()">
                <i class="fas fa-arrow-left"></i>
                <span>Konfirmasi Pemesanan</span>
            </button>
            <div class="progress-steps">
                <div class="step-item active">
                    <div class="step-circle">
                        <i class="fas fa-check"></i>
                    </div>
                    <span class="step-text">Alamat</span>
                </div>
                <div class="step-connector completed"></div>
                <div class="step-item">
                    <div class="step-circle">2</div>
                    <span class="step-text">Bayar</span>
                </div>
                <div class="step-connector"></div>
                <div class="step-item">
                    <div class="step-circle">3</div>
                    <span class="step-text">Faktur Pembayaran</span>
                </div>
            </div>
        </div>
        <form id="checkout-form" method="POST" action="{{ route('user.payments.shipping') }}">
        @csrf
        <div class="row">
            <!-- Order Summary (Kiri) -->
            <div class="col-lg-5 mb-4">
                <div class="section-card">
                    <h2 class="section-title">Order Summary</h2>
                    @foreach($products as $product)
                        <div class="product-item" data-price="{{ $product['harga'] }}" data-quantity="{{ $product['jumlah'] }}">
                            <img src="{{ $product['gambar'] }}" alt="{{ $product['nama'] }}" class="product-image">
                            <div class="product-details flex-grow-1">
                                <h6>{{ $product['nama'] }}</h6>
                                <span class="product-category">{{ $product['kategori'] }}</span>
                            </div>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn" onclick="decreaseQuantity(this)">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <span class="quantity-input">{{ $product['jumlah'] }}</span>
                                <button type="button" class="quantity-btn" onclick="increaseQuantity(this)">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <div class="product-price">Rp {{ number_format($product['harga'] * $product['jumlah'], 0, ',', '.') }}</div>
                        </div>
                    @endforeach

                    <!-- Ringkasan Total -->
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="subtotal">Rp 0</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkos Pengiriman</span>
                        <span id="shipping">Rp 0</span>
                    </div>
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="total">Rp 0</span>
                    </div>

                    <!-- Hidden input untuk backend -->
                    <input type="hidden" name="subtotal" id="input-subtotal">
                    <input type="hidden" name="ongkir" id="input-shipping">
                    <input type="hidden" name="total" id="input-total">

                    <!-- Shipping Terms -->
                    <div class="shipping-terms mt-4">
                        <h6>Pengiriman dan retur</h6>
                        <ul>
                            <li>Pemesanan dengan metode Pre-Order.</li>
                            <li>Pengiriman akan dilakukan setelah proses pembuatan selesai.</li>
                            <li>Untuk mengembalikan barang Anda, harap hubungi kami terlebih dahulu.</li>
                            <li>Biaya pos untuk pengembalian tidak dijamin.</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Detail Pemesanan (Kanan) -->
            <div class="col-lg-7">
                <div class="section-card">
                    <h2 class="section-title">Detail Pemesan</h2>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="nama_awal" class="form-label">Nama Awal</label>
                            <input type="text" class="form-control" id="nama_awal" name="nama_awal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="nama_akhir" class="form-label">Nama Akhir</label>
                            <input type="text" class="form-control" id="nama_akhir" name="nama_akhir" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone Number</label>
                        <div class="phone-input-group">
                            <select class="form-control country-code" name="country_code">
                                <option value="+62">+62</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                            </select>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                    </div>
                </div>
                <div class="section-card">
                    <h2 class="section-title">Detail Pengiriman</h2>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Jalan/Komplek</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="kecamatan" class="form-label">Kecamatan Tujuan</label>
                        <select class="form-control" id="kecamatan" name="kecamatan" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            @foreach($kecamatanList as $kec)
                                <option value="{{ $kec['nama'] }}" data-jarak="{{ $kec['jarak'] }}">{{ $kec['nama'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="distance-info" style="margin-top:10px;color:#1976d2;font-weight:600;"></div>
                    <div class="mb-3">
                        <label for="shipping_method" class="form-label">Opsi Pengiriman</label>
                        <select class="form-control" id="shipping_method" name="shipping_method" required>
                            <option value="reguler" data-delivery="8000">Reguler (Rp8.000)</option>
                            <option value="express" data-delivery="15000">Express (Rp15.000)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="blok_gang" class="form-label">Blok, Gang, Unit, No.</label>
                        <input type="text" class="form-control" id="blok_gang" name="blok_gang" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="kota" class="form-label">Kota/Kabupaten</label>
                            <input type="text" class="form-control" id="kota" name="kota" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="provinsi" class="form-label">Provinsi</label>
                            <input type="text" class="form-control" id="provinsi" name="provinsi" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="kode_pos" class="form-label">Kode Pos</label>
                        <input type="text" class="form-control" id="kode_pos" name="kode_pos" required>
                    </div>
                    <div class="form-check shipping-info mb-2">
                        <input class="form-check-input" type="checkbox" value="1" id="alamat_sama" name="alamat_sama" checked>
                        <label class="form-check-label" for="alamat_sama">
                            <i class="fas fa-info-circle"></i>
                            Alamat pengiriman dan invoice tagihan saya sama
                        </label>
                    </div>
                    <button type="submit" class="submit-btn">Lanjut</button>
                </div>
            </div>
        </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        function getSelectedJarak() {
            const kecamatanSelect = document.getElementById('kecamatan');
            const selected = kecamatanSelect.options[kecamatanSelect.selectedIndex];
            return parseInt(selected.getAttribute('data-jarak')) || 0;
        }
        function calculateShippingCost() {
            const jarak = getSelectedJarak();
            const shippingMethod = document.getElementById('shipping_method');
            const delivery = parseInt(shippingMethod.options[shippingMethod.selectedIndex].getAttribute('data-delivery')) || 0;
            return (jarak * 2000) + delivery;
        }
        function getSubtotal() {
            let subtotal = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const price = parseInt(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').textContent);
                subtotal += price * quantity;
            });
            return subtotal;
        }
        function formatRupiah(amount) {
            return 'Rp ' + amount.toLocaleString('id-ID');
        }
        function updateAllCalculation() {
            // Update harga per produk
            document.querySelectorAll('.product-item').forEach(item => {
                const price = parseInt(item.dataset.price);
                const quantity = parseInt(item.querySelector('.quantity-input').textContent);
                const itemTotal = price * quantity;
                item.querySelector('.product-price').textContent = formatRupiah(itemTotal);
            });
            const subtotal = getSubtotal();
            const shippingCost = calculateShippingCost();
            const total = subtotal + shippingCost;
            const jarak = getSelectedJarak();
            document.getElementById('subtotal').textContent = formatRupiah(subtotal);
            document.getElementById('shipping').textContent = formatRupiah(shippingCost);
            document.getElementById('total').textContent = formatRupiah(total);
            document.getElementById('input-subtotal').value = subtotal;
            document.getElementById('input-shipping').value = shippingCost;
            document.getElementById('input-total').value = total;
            document.getElementById('distance-info').textContent =
                jarak ? `Jarak dari Kiaracondong: ${jarak} km` : '';
        }
        function increaseQuantity(button) {
            const productItem = button.closest('.product-item');
            const quantityDisplay = productItem.querySelector('.quantity-input');
            let currentQuantity = parseInt(quantityDisplay.textContent);
            currentQuantity++;
            quantityDisplay.textContent = currentQuantity;
            productItem.dataset.quantity = currentQuantity;
            updateAllCalculation();
        }
        function decreaseQuantity(button) {
            const productItem = button.closest('.product-item');
            const quantityDisplay = productItem.querySelector('.quantity-input');
            let currentQuantity = parseInt(quantityDisplay.textContent);
            if (currentQuantity > 1) {
                currentQuantity--;
                quantityDisplay.textContent = currentQuantity;
                productItem.dataset.quantity = currentQuantity;
                updateAllCalculation();
            }
        }
        document.getElementById('kecamatan').addEventListener('change', updateAllCalculation);
        document.getElementById('shipping_method').addEventListener('change', updateAllCalculation);
        window.addEventListener('DOMContentLoaded', updateAllCalculation);
        function goBack() {
            window.history.back();
        }
    </script>
    @include('footer')
</body>
</html>