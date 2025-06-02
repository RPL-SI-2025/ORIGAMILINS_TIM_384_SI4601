<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-tZKK0PWiSK_48jYX"></script>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f59e0b;YOUR_SNAP_TOKE
            --success-color: #10b981;
            --gray-100: #f8fafc;
            --gray-200: #e2e8f0;
            --gray-600: #64748b;
            --gray-800: #1e293b;
        }
        body {
            background-color: var(--gray-100);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .container-custom {
            max-width: 1100px;
            margin: 0 auto;
            padding: 32px 0;
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
        .main-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }
        .section-title i {
            margin-right: 0.5rem;
            color: var(--primary-color);
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            margin-bottom: 1rem;
            background: white;
        }
        .product-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            object-fit: cover;
            margin-right: 1rem;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-name {
            font-weight: 600;
            color: var(--gray-800);
            margin-bottom: 0.25rem;
        }
        .product-category {
            font-size: 0.75rem;
            color: var(--primary-color);
            background-color: #eef2ff;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            display: inline-block;
        }
        .product-price {
            font-weight: 600;
            color: var(--gray-800);
        }
        .shipping-info {
            background: #f8fafc;
            border: 1px solid var(--gray-200);
            border-radius: 12px;
            padding: 1.5rem;
        }
        .info-row {
            display: flex;
            margin-bottom: 0.5rem;
        }
        .info-label {
            font-weight: 500;
            color: var(--gray-600);
            min-width: 120px;
        }
        .info-value {
            color: var(--gray-800);
            flex-grow: 1;
        }
        .summary-table {
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
        }
        .summary-row:last-child {
            border-bottom: none;
            background: #f8fafc;
            font-weight: 600;
            font-size: 1.1rem;
        }
        .payment-button {
            background: #10b981;
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: #fff;
            transition: all 0.3s ease;
            width: 100%;
            box-shadow: 0 4px 16px rgba(16,185,129,0.12);
            display: block;
            text-align: center;
        }
        .payment-button:hover, .payment-button:focus {
            background: #059669;
            color: #fff;
            outline: none;
        }
        .payment-button:disabled {
            background: #e2e8f0;
            color: #6c757d;
            cursor: not-allowed;
        }
        .order-info {
            background: #fff7ed;
            border: 1px solid #fed7aa;
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }
        .edit-link {
            color: var(--secondary-color);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
        }
        .edit-link:hover {
            color: #d97706;
        }
        @media (max-width: 992px) {
            .container-custom {
                padding: 16px 0;
            }
        }
        @media (max-width: 768px) {
            .container-custom {
                padding: 8px 0;
            }
            .progress-header {
                padding: 12px;
            }
            .product-item {
                flex-wrap: wrap;
            }
            .product-image {
                width: 50px;
                height: 50px;
            }
        }
    </style>
</head>
<body>
    @include('user.navigation-menu')
    <div class="container container-custom">
        <!-- Progress Stepper -->
        <div class="progress-header">
            <button class="back-btn" onclick="window.history.back()">
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
                <div class="step-item active">
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
        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="main-card p-4">
                    <!-- Detail Produk -->
                    <div class="mb-4">
                        <h5 class="section-title">
                            <i class="fas fa-box"></i>
                            Detail Produk
                        </h5>
                        @foreach($items as $item)
                        <div class="product-item">
                            <img src="{{ $item->produk->gambar ?? 'https://via.placeholder.com/60x60?text=IMG' }}" 
                                 alt="{{ $item->produk->nama }}" class="product-image">
                            <div class="product-details">
                                <div class="product-name">{{ $item->produk->nama }}</div>
                                <span class="product-category">{{ $item->produk->kategori }}</span>
                            </div>
                            <div class="text-end">
                                <div class="product-price">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</div>
                                <small class="text-muted">Qty: {{ $item->jumlah }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <!-- Detail Pengiriman -->
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="section-title mb-0">
                                <i class="fas fa-truck"></i>
                                Detail Pengiriman
                            </h5>
                            <a href="#" class="edit-link">Edit Detail</a>
                        </div>
                        <div class="shipping-info">
                            <div class="mb-3">
                                <strong>Alamat Pengiriman</strong>
                            </div>
                            <div class="info-row">
                                <div class="info-value">
                                    <strong>{{ $alamat['nama_awal'] ?? '' }} {{ $alamat['nama_akhir'] ?? '' }}</strong><br>
                                    {{ $alamat['alamat'] ?? '' }}{{ $alamat['blok_gang'] ? ', '.$alamat['blok_gang'] : '' }}, 
                                    {{ $alamat['kecamatan'] ?? '' }}, {{ $alamat['kota'] ?? '' }}, 
                                    {{ $alamat['provinsi'] ?? '' }} {{ $alamat['kode_pos'] ?? '' }}
                                </div>
                            </div>
                            <div class="info-row mt-3">
                                <span class="info-label">Alamat Invoice:</span>
                                <span class="info-value">
                                    {{ (isset($alamat['alamat_sama']) && $alamat['alamat_sama']) ? 'Sama dengan alamat pengiriman' : 'Berbeda' }}
                                </span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Informasi Kontak:</span>
                                <span class="info-value">{{ $alamat['email'] ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                    <!-- Order Information -->
                    <div class="order-info">
                        <div class="d-flex justify-content-between">
                            <div>
                                <strong>Order ID:</strong> {{ $payment->order_id ?? '-' }}<br>
                                <strong>Email:</strong> {{ $payment->email ?? ($alamat['email'] ?? '-') }}
                            </div>
                            <div class="text-end">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Valid hingga: 24 jam
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Ringkasan Pembayaran -->
            <div class="col-lg-4">
                <div class="main-card p-4">
                <h5 class="section-title">
                    <i class="fas fa-calculator"></i>
                    Ringkasan Pembayaran
                </h5>
                <div class="summary-table mb-3">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Ongkir</span>
                        <span>Rp {{ number_format($ongkir ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
                <button id="pay-button" class="payment-button">
                    <i class="fas fa-credit-card me-2"></i>
                    Bayar Sekarang - Rp {{ number_format($total ?? 0, 0, ',', '.') }}
                </button>
                <small class="text-center text-muted mt-2 d-block">
                    <i class="fas fa-shield-alt me-1"></i>
                    Pembayaran aman dengan Midtrans
                </small>
            </div>
                <!-- Payment Methods Info -->
                <div class="mt-4 text-center">
                    <small class="text-muted">Metode pembayaran yang tersedia:</small>
                    <div class="d-flex justify-content-center flex-wrap mt-2 gap-2">
                        <span class="badge bg-light text-dark">QRIS</span>
                        <span class="badge bg-light text-dark">GoPay</span>
                        <span class="badge bg-light text-dark">OVO</span>
                        <span class="badge bg-light text-dark">DANA</span>
                        <span class="badge bg-light text-dark">Bank Transfer</span>
                        <span class="badge bg-light text-dark">Credit Card</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Ganti dengan snap token dari backend
        const snapToken = '{{ $payment->snap_token ?? "YOUR_SNAP_TOKEN" }}';
        document.getElementById('pay-button').onclick = function() {
            if (!snapToken || snapToken === 'YOUR_SNAP_TOKEN') {
                alert('Snap token belum tersedia. Pastikan data pembayaran sudah dibuat di backend.');
                return;
            }
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '/payment/success/' + result.order_id;
                },
                onPending: function(result) {
                    window.location.href = '/payment/pending/' + result.order_id;
                },
                onError: function(result) {
                    alert('Terjadi kesalahan saat memproses pembayaran. Coba lagi.');
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card me-2"></i>Bayar Sekarang - Rp {{ number_format($total ?? 0, 0, ',', '.') }}';
                },
                onClose: function() {
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card me-2"></i>Bayar Sekarang - Rp {{ number_format($total ?? 0, 0, ',', '.') }}';
                }
            });
        };
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @include('footer')

</body>
</html>