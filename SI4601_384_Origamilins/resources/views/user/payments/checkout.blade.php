<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pemesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="YOUR_CLIENT_KEY"></script>
    <style>
        :root {
            --primary-color: #4f46e5;
            --secondary-color: #f59e0b;
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
        .step {
            display: flex;
            align-items: center;
            color: var(--gray-600);
            font-size: 0.9rem;
            font-weight: 500;
        }

        .step.active {
            color: var(--secondary-color);
        }

        .step.completed {
            color: var(--success-color);
        }

        .step-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-color: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            font-size: 0.8rem;
        }

        .step.active .step-icon {
            background-color: var(--secondary-color);
            color: white;
        }

        .step.completed .step-icon {
            background-color: var(--success-color);
            color: white;
        }

        .step-connector {
            width: 60px;
            height: 2px;
            background-color: var(--gray-200);
            margin: 0 1rem;
        }

        .step.completed + .step-connector {
            background-color: var(--success-color);
        }

        .main-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
        }

        .card-header-custom {
            background: linear-gradient(135deg, var(--primary-color) 0%, #6366f1 100%);
            color: white;
            padding: 1.5rem;
            border: none;
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

        .product-specs {
            font-size: 0.85rem;
            color: var(--gray-600);
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
            background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            font-size: 1.1rem;
            color: white;
            transition: all 0.3s ease;
            width: 100%;
        }

        .payment-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .payment-button:disabled {
            background: var(--gray-200);
            color: var(--gray-600);
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

        @media (max-width: 768px) {
            .progress-stepper {
                font-size: 0.8rem;
                padding: 0 1rem;
            }
            
            .step-connector {
                width: 40px;
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
   @include('user.navigation-menu ')
    <!-- Progress Stepper -->
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
                    
                    <div class="card-body p-4">
                        <!-- Detail Produk -->
                        <div class="mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-box"></i>
                                Detail Produk
                            </h5>
                            
                            <!-- Sample Product - Replace with dynamic data -->
                            <div class="product-item">
                                <img src="https://via.placeholder.com/60x60/FF6B6B/FFFFFF?text=🌸" 
                                     alt="Bunga Kertas" class="product-image">
                                <div class="product-details">
                                    <div class="product-name">Bunga Kertas</div>
                                    <div class="product-specs">Handmade paper flowers</div>
                                    <span class="product-category">Dekorasi</span>
                                </div>
                                <div class="text-end">
                                    <div class="product-price">Rp 250.000</div>
                                    <small class="text-muted">Qty: 1</small>
                                </div>
                            </div>
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
                                        <strong>John Doe</strong><br>
                                        Gg. PGA Blok Braja No.104, RT./RW.04/02, Lengkong, Kec. Bojongsoang, Kabupaten Bandung, Jawa Barat 40287
                                    </div>
                                </div>
                                <div class="info-row mt-3">
                                    <span class="info-label">Alamat Invoice:</span>
                                    <span class="info-value">Sama dengan alamat pengiriman</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Informasi Kontak:</span>
                                    <span class="info-value">custdummy@gmail.com</span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Information -->
                        <div class="order-info">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>Order ID:</strong> ORD-2024-001<br>
                                    <strong>Email:</strong> custdummy@gmail.com
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">
                                        <i class="fas fa-clock me-1"></i>
                                        Valid hingga: 24 jam
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Ringkasan Pembayaran -->
                        <div class="mb-4">
                            <h5 class="section-title">
                                <i class="fas fa-calculator"></i>
                                Ringkasan Pembayaran
                            </h5>
                            
                            <div class="summary-table">
                                <div class="summary-row">
                                    <span>Subtotal</span>
                                    <span>Rp 250.000</span>
                                </div>
                                <div class="summary-row">
                                    <span>Ongkir (JNE Regular)</span>
                                    <span>Rp 15.000</span>
                                </div>
                                <div class="summary-row">
                                    <span>Total Pembayaran</span>
                                    <span>Rp 265.000</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Button -->
                        <div class="d-grid gap-2">
                            <button id="pay-button" class="payment-button">
                                <i class="fas fa-credit-card me-2"></i>
                                Bayar Sekarang - Rp 265.000
                            </button>
                            <small class="text-center text-muted mt-2">
                                <i class="fas fa-shield-alt me-1"></i>
                                Pembayaran aman dengan Midtrans
                            </small>
                        </div>
                    </div>
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
        // Sample snap token - replace with actual token from backend
        const snapToken = 'YOUR_SNAP_TOKEN';
        
        document.getElementById('pay-button').onclick = function() {
            // Check if snap token exists
            if (!snapToken || snapToken === 'YOUR_SNAP_TOKEN') {
                alert('Snap token belum tersedia. Pastikan data pembayaran sudah dibuat di backend.');
                return;
            }

            // Disable button during payment process
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses...';
            
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href = '/payment/success/' + result.order_id;
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href = '/payment/pending/' + result.order_id;
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    alert('Terjadi kesalahan saat memproses pembayaran. Coba lagi.');
                    // Re-enable button
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card me-2"></i>Bayar Sekarang - Rp 265.000';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    // Re-enable button
                    document.getElementById('pay-button').disabled = false;
                    document.getElementById('pay-button').innerHTML = '<i class="fas fa-credit-card me-2"></i>Bayar Sekarang - Rp 265.000';
                }
            });
        };

        // Auto-refresh token setiap 30 menit untuk menghindari expired token
        setInterval(function() {
            console.log('Checking token validity...');
            // Implement token refresh logic here if needed
        }, 30 * 60 * 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>