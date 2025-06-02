    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Faktur Pembayaran - Origamilins</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --primary-color: #4f46e5;
                --success-color: #10b981;
                --warning-color: #f59e0b;
                --secondary-color: #6b7280;
                --light-bg: #f8fafc;
                --card-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            body {
                background-color: var(--gray-100);
                min-height: 100vh;
                font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                padding: 2rem 0;
            }

            .main-container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 0 1rem;
            }

            .header-brand {
                background: white;
                padding: 1rem 2rem;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
                display: flex;
                align-items: center;
                animation: slideDown 0.6s ease-out;
            }

            @keyframes slideDown {
                from {
                    opacity: 0;
                    transform: translateY(-30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .brand-logo {
                font-size: 1.8rem;
                font-weight: bold;
                color: var(--warning-color);
                margin-right: 0.5rem;
            }

            .brand-name {
                font-size: 1.8rem;
                font-weight: 700;
                color: var(--primary-color);
                margin: 0;
            }

            .progress-bar-container {
                background: white;
                padding: 2rem;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                margin-bottom: 2rem;
                animation: fadeInUp 0.6s ease-out 0.2s both;
            }

            .progress-steps {
                display: flex;
                justify-content: space-between;
                align-items: center;
                position: relative;
            }

            .progress-line {
                position: absolute;
                top: 50%;
                left: 0;
                right: 0;
                height: 4px;
                background: #e5e7eb;
                border-radius: 2px;
                z-index: 1;
            }

            .progress-line-fill {
                height: 100%;
                background: linear-gradient(90deg, var(--success-color), var(--warning-color));
                border-radius: 2px;
                width: 100%;
                animation: progressFill 1s ease-out 0.5s both;
            }

            @keyframes progressFill {
                from { width: 0%; }
                to { width: 100%; }
            }

            .step {
                display: flex;
                flex-direction: column;
                align-items: center;
                z-index: 2;
                background: white;
                padding: 0.5rem;
                border-radius: 12px;
            }

            .step-circle {
                width: 50px;
                height: 50px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-weight: bold;
                color: white;
                margin-bottom: 0.5rem;
                animation: bounce 0.6s ease-out;
            }

            .step-circle.completed {
                background: var(--success-color);
            }

            .step-circle.current {
                background: var(--warning-color);
                animation: pulse 2s infinite;
            }

            .step-circle.pending {
                background: #d1d5db;
                color: #6b7280;
            }

            @keyframes bounce {
                0%, 20%, 53%, 80%, 100% { transform: translate3d(0,0,0); }
                40%, 43% { transform: translate3d(0,-10px,0); }
                70% { transform: translate3d(0,-5px,0); }
                90% { transform: translate3d(0,-2px,0); }
            }

            @keyframes pulse {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.1); }
            }

            .step-label {
                font-size: 0.9rem;
                font-weight: 600;
                color: var(--secondary-color);
                text-align: center;
            }

            .main-content {
                display: grid;
                grid-template-columns: 1fr 400px;
                gap: 2rem;
                animation: fadeInUp 0.6s ease-out 0.4s both;
            }

            .content-card {
                background: white;
                border-radius: 16px;
                box-shadow: var(--card-shadow);
                overflow: hidden;
            }

            .card-header {
                padding: 1.5rem 2rem;
                background: linear-gradient(135deg, var(--primary-color), #1d4ed8);
                color: white;
                display: flex;
                align-items: center;
                gap: 0.75rem;
            }

            .card-title {
                font-size: 1.3rem;
                font-weight: 700;
                margin: 0;
            }

            .card-body {
                padding: 2rem;
            }

            .product-item {
                display: flex;
                align-items: center;
                gap: 1rem;
                padding: 1.5rem;
                background: var(--light-bg);
                border-radius: 12px;
                margin-bottom: 1rem;
                transition: all 0.3s ease;
            }

            .product-item:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            }

            .product-image {
                width: 80px;
                height: 80px;
                background: #e5e7eb;
                border-radius: 12px;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 2rem;
                color: var(--secondary-color);
            }

            .product-details {
                flex: 1;
            }

            .product-name {
                font-size: 1.1rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.25rem;
            }

            .product-category {
                font-size: 0.9rem;
                color: var(--primary-color);
                background: rgba(37, 99, 235, 0.1);
                padding: 0.25rem 0.75rem;
                border-radius: 20px;
                display: inline-block;
            }

            .product-price {
                font-size: 1.1rem;
                font-weight: 700;
                color: var(--success-color);
            }

            .product-qty {
                font-size: 0.9rem;
                color: var(--secondary-color);
                margin-top: 0.25rem;
            }

            .shipping-info {
                background: var(--light-bg);
                padding: 1.5rem;
                border-radius: 12px;
                margin-top: 1rem;
            }

            .info-section {
                margin-bottom: 1.5rem;
            }

            .info-title {
                font-size: 1rem;
                font-weight: 600;
                color: #1f2937;
                margin-bottom: 0.75rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .info-content {
                color: var(--secondary-color);
                line-height: 1.6;
            }

            .order-summary {
                background: var(--light-bg);
                padding: 1.5rem;
                border-radius: 12px;
            }

            .summary-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px solid #e5e7eb;
            }

            .summary-row:last-child {
                border-bottom: none;
                font-weight: 700;
                font-size: 1.1rem;
                color: var(--success-color);
                padding-top: 1rem;
                margin-top: 0.5rem;
                border-top: 2px solid var(--success-color);
            }

            .payment-methods {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
                margin-top: 1rem;
            }

            .payment-method {
                padding: 1rem;
                border: 2px solid #e5e7eb;
                border-radius: 12px;
                text-align: center;
                transition: all 0.3s ease;
                cursor: pointer;
                font-size: 0.9rem;
                font-weight: 600;
            }

            .payment-method:hover {
                border-color: var(--primary-color);
                transform: translateY(-2px);
            }

            .payment-method.active {
                border-color: var(--success-color);
                background: rgba(16, 185, 129, 0.1);
                color: var(--success-color);
            }

            .security-badge {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                color: var(--success-color);
                font-size: 0.9rem;
                font-weight: 600;
                margin-top: 1rem;
                padding: 0.75rem;
                background: rgba(16, 185, 129, 0.1);
                border-radius: 8px;
            }

            .order-info-box {
                background: linear-gradient(135deg, var(--success-color), #059669);
                color: white;
                padding: 1.5rem;
                border-radius: 12px;
                margin-bottom: 1rem;
            }

            .order-id {
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 0.5rem;
            }

            .order-email {
                font-size: 0.9rem;
                opacity: 0.9;
            }

            .validity-info {
                background: rgba(245, 158, 11, 0.1);
                color: var(--warning-color);
                padding: 1rem;
                border-radius: 8px;
                font-size: 0.9rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
                margin-top: 1rem;
            }

            .success-animation {
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--success-color);
                color: white;
                padding: 1rem 1.5rem;
                border-radius: 12px;
                box-shadow: var(--card-shadow);
                display: flex;
                align-items: center;
                gap: 0.75rem;
                font-weight: 600;
                animation: slideInRight 0.6s ease-out;
                z-index: 1000;
            }

            @keyframes slideInRight {
                from {
                    opacity: 0;
                    transform: translateX(100%);
                }
                to {
                    opacity: 1;
                    transform: translateX(0);
                }
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            @media (max-width: 768px) {
                .main-content {
                    grid-template-columns: 1fr;
                    gap: 1rem;
                }
                
                .header-brand {
                    padding: 1rem;
                    text-align: center;
                    flex-direction: column;
                    gap: 0.5rem;
                }
                
                .progress-steps {
                    flex-direction: column;
                    gap: 1rem;
                }
                
                .progress-line {
                    display: none;
                }
                
                .payment-methods {
                    grid-template-columns: repeat(2, 1fr);
                }
            }
        </style>
    </head>
    <body>
        @include('user.navigation-menu')
         @php
            $alamat = $alamat ?? [];
        @endphp

        <div class="success-animation">
            <i class="fas fa-check-circle"></i>
            <span>Pembayaran Berhasil!</span>
        </div>

        <div class="main-container">
            <!-- Header Brand -->
            <!-- Progress Bar -->
            <div class="progress-bar-container">
                <div class="progress-steps">
                    <div class="progress-line">
                        <div class="progress-line-fill"></div>
                    </div>
                    <div class="step">
                        <div class="step-circle completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="step-label">Alamat</div>
                    </div>
                    <div class="step">
                        <div class="step-circle completed">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="step-label">Bayar</div>
                    </div>
                    <div class="step">
                        <div class="step-circle current">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <div class="step-label">Faktur Pembayaran</div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Left Column - Product Details -->
                <div>
                    <div class="content-card">
                        <div class="card-header">
                            <i class="fas fa-box"></i>
                            <h2 class="card-title">Detail Produk</h2>
                        </div>
                        <div class="card-body">
    @forelse($items as $item)
    <div class="product-item">
        <div class="product-image">
            @php
                // Jika dari model Pesanan, ambil relasi produk
                if (is_object($item) && isset($item->produk)) {
                    $produk = $item->produk;
                    $jumlah = $item->jumlah;
                } elseif (is_array($item)) {
                    $produk = (object) $item;
                    $jumlah = $item['jumlah'] ?? 1;
                } else {
                    $produk = null;
                    $jumlah = 1;
                }
                $gambar = $produk->gambar ?? null;
                $nama = $produk->nama ?? 'Produk';
                $kategori = $produk->kategori ?? 'Kategori';
                $harga = $produk->harga ?? 0;
            @endphp

            @if($gambar)
                <img src="{{ $gambar }}" alt="{{ $nama }}" style="width:60px;height:60px;border-radius:8px;object-fit:cover;">
            @else
                🐦
            @endif
        </div>
        <div class="product-details">
            <div class="product-name">{{ $nama }}</div>
            <div class="product-category">{{ $kategori }}</div>
            <div class="product-qty">Qty: {{ $jumlah }}</div>
            <div class="product-price">
                Rp {{ number_format($harga * $jumlah, 0, ',', '.') }}
            </div>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-4">
        <i class="fas fa-box-open fa-3x mb-3"></i>
        <p>Tidak ada produk ditemukan</p>
        @if(auth()->check())
            <div class="mt-3">
                <small class="text-info">
                    Debug Info: 
                    Payment ID: {{ $payment->id ?? 'N/A' }} | 
                    Items Count: {{ is_countable($items) ? count($items) : $items->count() }} |
                    User ID: {{ auth()->id() }}
                </small>
            </div>
        @endif
    </div>
@endforelse
</div>

                    <div class="content-card mt-4">
                        <div class="card-header">
                            <i class="fas fa-truck"></i>
                            <h2 class="card-title">Detail Pengiriman</h2>
                        </div>
                        <div class="card-body">
                            <div class="shipping-info">
                                <div class="info-section">
                                    <div class="info-title">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Alamat Pengiriman
                                    </div>
                                    <div class="info-content">
                                        <strong>{{ $alamat['nama_awal'] ?? '' }} {{ $alamat['nama_akhir'] ?? '' }}</strong><br>
                                        {{ $alamat['alamat'] ?? '' }}{{ isset($alamat['blok_gang']) && $alamat['blok_gang'] ? ', '.$alamat['blok_gang'] : '' }},
                                        {{ $alamat['kecamatan'] ?? '' }}, {{ $alamat['kota'] ?? '' }}, 
                                        {{ $alamat['provinsi'] ?? '' }} {{ $alamat['kode_pos'] ?? '' }}
                                    </div>
                                </div>
                                <div class="info-section">
                                    <div class="info-title">
                                        <i class="fas fa-file-invoice"></i>
                                        Alamat Invoice
                                    </div>
                                    <div class="info-content">
                                        {{ (isset($alamat['alamat_sama']) && $alamat['alamat_sama']) ? 'Sama dengan alamat pengiriman' : 'Berbeda' }}
                                    </div>
                                </div>
                                <div class="info-section">
                                    <div class="info-title">
                                        <i class="fas fa-envelope"></i>
                                        Informasi Kontak
                                    </div>
                                    <div class="info-content">{{ $alamat['email'] ?? $payment->email }}</div>
                                </div>
                            </div>

                            <div class="order-info-box">
                                <div class="order-id">
                                    <i class="fas fa-hashtag me-2"></i>
                                    Order ID: {{ $payment->order_id }}
                                </div>
                                <div class="order-email">
                                    <i class="fas fa-envelope me-2"></i>
                                    Email: {{ $payment->email ?? ($alamat['email'] ?? '-') }}
                                </div>
                            </div>

                            <div class="validity-info">
                                <i class="fas fa-clock"></i>
                                <span>Valid hingga: 24 jam</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Payment Summary -->
                <div>
                    <div class="content-card">
                        <div class="card-header">
                            <i class="fas fa-calculator"></i>
                            <h2 class="card-title">Ringkasan Pembayaran</h2>
                        </div>
                        <div class="card-body">
                            <div class="order-summary">
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

                            <div class="security-badge">
                                <i class="fas fa-shield-alt"></i>
                                <span>Pembayaran aman dengan Midtrans</span>
                            </div>

                            <div class="mt-4">
                                <h6 class="mb-3">Metode pembayaran yang tersedia:</h6>
                                <div class="payment-methods">
                                    <div class="payment-method">QRIS</div>
                                    <div class="payment-method">GoPay</div>
                                    <div class="payment-method">OVO</div>
                                    <div class="payment-method">DANA</div>
                                    <div class="payment-method">Bank Transfer</div>
                                    <div class="payment-method">Credit Card</div>
                                </div>
                            </div>

                            <div class="mt-4 p-3 bg-success bg-opacity-10 rounded-3">
                                <div class="d-flex align-items-center text-success">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <strong>Pembayaran Berhasil!</strong>
                                </div>
                                <small class="text-muted">
                                    Transaksi telah berhasil diproses menggunakan {{ ucfirst($payment->payment_type ?? 'Midtrans') }}
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            // Auto hide success notification
            setTimeout(() => {
                const successNotification = document.querySelector('.success-animation');
                if (successNotification) {
                    successNotification.style.animation = 'slideInRight 0.6s ease-out reverse';
                    setTimeout(() => {
                        successNotification.remove();
                    }, 600);
                }
            }, 5000);

            // Add confetti effect
            function createConfetti() {
                const colors = ['#10b981', '#f59e0b', '#2563eb', '#ef4444', '#8b5cf6'];
                const confettiCount = 30;
                
                for (let i = 0; i < confettiCount; i++) {
                    setTimeout(() => {
                        const confetti = document.createElement('div');
                        confetti.style.position = 'fixed';
                        confetti.style.width = '8px';
                        confetti.style.height = '8px';
                        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                        confetti.style.left = Math.random() * 100 + '%';
                        confetti.style.top = '-10px';
                        confetti.style.zIndex = '999';
                        confetti.style.pointerEvents = 'none';
                        confetti.style.borderRadius = '50%';
                        
                        document.body.appendChild(confetti);
                        
                        const fallDuration = Math.random() * 2000 + 1500;
                        const horizontalMovement = (Math.random() - 0.5) * 100;
                        
                        confetti.animate([
                            { transform: 'translateY(0) translateX(0) rotate(0deg)', opacity: 1 },
                            { transform: `translateY(${window.innerHeight + 50}px) translateX(${horizontalMovement}px) rotate(360deg)`, opacity: 0 }
                        ], {
                            duration: fallDuration,
                            easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                        }).onfinish = () => {
                            confetti.remove();
                        };
                    }, i * 50);
                }
            }

            // Trigger confetti on page load
            window.addEventListener('load', () => {
                setTimeout(createConfetti, 1000);
            });

            // Add smooth interactions
            document.querySelectorAll('.product-item, .payment-method').forEach(item => {
                item.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px) scale(1.02)';
                });
                
                item.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0) scale(1)';
                });
            });
        </script>
        @include('user.footer')
    </body>
    </html>