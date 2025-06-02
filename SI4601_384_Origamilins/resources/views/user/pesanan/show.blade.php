<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f5f5f5;
            font-family: 'Inter', sans-serif;
        }

        .shopee-progress {
            padding: 2rem 1rem;
        }

        .progress-container {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
        }

        .progress-step {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-width: 120px;
        }

        .step-wrapper {
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 1rem;
            justify-content: center;
        }

        .step-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #e5e7eb;
            border: 3px solid #e5e7eb;
            color: #9ca3af;
            font-size: 16px;
            font-weight: 600;
            position: relative;
            z-index: 2;
            transition: all 0.3s ease;
        }

        .progress-step.completed .step-icon {
            background: #10b981;
            border-color: #10b981;
            color: white;
        }

        .progress-step.active .step-icon {
            background: #ee4d2d;
            border-color: #ee4d2d;
            color: white;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
            }
        }

        .active-dot,
        .inactive-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: currentColor;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 60px;
            right: -60px;
            height: 3px;
            background: #e5e7eb;
            transform: translateY(-50%);
            z-index: 1;
        }

        .progress-line.filled {
            background: #10b981;
        }

        .step-info {
            text-align: center;
        }

        .step-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 0.5rem;
        }

        .step-title.active-text {
            color: #1f2937;
        }

        .step-time {
            font-size: 0.75rem;
            color: #9ca3af;
            background: rgba(16, 185, 129, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 1rem;
            display: inline-block;
        }

        .card {
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .shipping-icon {
            width: 48px;
            height: 48px;
            background: rgba(16, 185, 129, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .address-card {
            padding: 1rem;
            background: #f8f9fa;
            border-radius: 0.5rem;
            border-left: 4px solid #ee4d2d;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.75rem;
        }

        .info-label {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .info-value {
            font-weight: 500;
            color: #495057;
        }

        .product-image {
            width: 80px;
            height: 80px;
            flex-shrink: 0;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border: 1px solid #e9ecef;
        }

        .product-name {
            font-weight: 600;
            color: #212529;
            line-height: 1.4;
        }

        .quantity-badge {
            background: #f8f9fa;
            color: #6c757d;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
            border: 1px solid #e9ecef;
        }

        .payment-summary {
            max-width: 400px;
            margin-left: auto;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
        }

        .summary-label {
            color: #6c757d;
            font-size: 0.95rem;
        }

        .summary-value {
            font-weight: 500;
            color: #495057;
        }

        .total-row {
            background: #f8f9fa;
            margin: 0 -1.5rem;
            padding: 1rem 1.5rem;
            border-radius: 0.5rem;
        }

        .btn-lg {
            border-radius: 0.5rem;
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .progress-container {
                flex-direction: column;
                gap: 1rem;
            }

            .progress-step {
                flex-direction: row;
                text-align: left;
                min-width: auto;
                width: 100%;
            }

            .step-wrapper {
                margin-bottom: 0;
                margin-right: 1rem;
                width: auto;
            }

            .progress-line {
                display: none;
            }

            .info-row {
                flex-direction: column;
                gap: 0.25rem;
            }

            .payment-summary {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    @include('user.navigation-menu')

    <div class="container my-4">
        <!-- Progress Bar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                @php
                    $steps = [
                        ['label' => 'Pesanan Dibuat', 'date' => $pesanan->created_at ? $pesanan->created_at->format('d-m-Y H:i') : '-'],
                        ['label' => 'Pesanan Dibayarkan', 'date' => $pesanan->dibayar_at ? $pesanan->dibayar_at->format('d-m-Y H:i') : '-'],
                        ['label' => 'Pesanan Dikirimkan', 'date' => $pesanan->dikirim_at ? $pesanan->dikirim_at->format('d-m-Y H:i') : '-'],
                        ['label' => 'Dikirim', 'date' => $pesanan->dikirim_at ? $pesanan->dikirim_at->format('d-m-Y H:i') : '-'],
                        ['label' => $pesanan->status == 'selesai' ? 'Selesai' : 'Belum Dinilai', 'date' => $pesanan->selesai_at ? $pesanan->selesai_at->format('d-m-Y H:i') : '-'],
                    ];
                    $statusStep = [
                        'rencana' => 1,
                        'proses' => 2,
                        'siap' => 3,
                        'dikirim' => 4,
                        'selesai' => 5,
                    ];
                    $activeStep = $statusStep[$pesanan->status] ?? 1;
                @endphp
                <div class="shopee-progress">
                    <div class="progress-container">
                        @foreach($steps as $i => $step)
                            <div class="progress-step {{ $i + 1 <= $activeStep ? 'completed' : '' }} {{ $i + 1 == $activeStep ? 'active' : '' }}">
                                <div class="step-wrapper">
                                    <div class="step-icon">
                                        @if($i + 1 < $activeStep)
                                            <i class="bi bi-check-lg"></i>
                                        @elseif($i + 1 == $activeStep)
                                            <div class="active-dot"></div>
                                        @else
                                            <div class="inactive-dot"></div>
                                        @endif
                                    </div>
                                    @if($i < count($steps) - 1)
                                        <div class="progress-line {{ $i + 2 <= $activeStep ? 'filled' : '' }}"></div>
                                    @endif
                                </div>
                                <div class="step-info">
                                    <div class="step-title {{ $i + 1 <= $activeStep ? 'active-text' : '' }}">
                                        {{ $step['label'] }}
                                    </div>
                                    @if($step['date'] !== '-')
                                        <div class="step-time">{{ $step['date'] }}</div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Alamat & Info Pesanan -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="address-card">
                            <div class="recipient-name fw-bold mb-1">{{ $alamat['nama_awal'] ?? '-' }} {{ $alamat['nama_akhir'] ?? '' }}</div>
                            <div class="recipient-phone text-muted mb-2">{{ $alamat['telepon'] ?? '-' }}</div>
                            <div class="recipient-address">
                                {{ $alamat['alamat'] ?? '-' }}{{ isset($alamat['blok_gang']) && $alamat['blok_gang'] ? ', '.$alamat['blok_gang'] : '' }},
                                {{ $alamat['kecamatan'] ?? '' }}, {{ $alamat['kota'] ?? '' }}, {{ $alamat['provinsi'] ?? '' }} {{ $alamat['kode_pos'] ?? '' }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="order-info">
                            <div class="info-row">
                                <span class="info-label">Order ID:</span>
                                <span class="info-value fw-bold text-primary">{{ $pesanan->id_pesanan }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Tanggal Pemesanan:</span>
                                <span class="info-value">{{ $pesanan->created_at ? $pesanan->created_at->format('d-m-Y H:i') : '-' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Status:</span>
                                <span class="badge bg-success">{{ ucfirst($pesanan->status) }}</span>
                            </div>
                            @if($pesanan->no_resi)
                                <div class="info-row">
                                    <span class="info-label">No. Resi:</span>
                                    <span class="info-value text-primary fw-bold">{{ $pesanan->no_resi }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Produk -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-0">
                @if($pesanan->items && count($pesanan->items) > 0)
                    @foreach($pesanan->items as $item)
                        <div class="product-item border-bottom">
                            <div class="d-flex align-items-center p-4">
                                <div class="product-image me-3">
                                    @if($item->produk && $item->produk->gambar)
                                        <img src="{{ asset('storage/' . $item->produk->gambar) }}" alt="{{ $item->produk->nama_produk }}" class="img-fluid rounded">
                                    @else
                                        <div class="no-image d-flex align-items-center justify-content-center">
                                            <i class="bi bi-image text-muted"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="product-info flex-grow-1">
                                    <h6 class="product-name mb-2">{{ $item->produk->nama_produk ?? '-' }}</h6>
                                    <div class="product-variant text-muted mb-2">
                                        <small>Variasi: {{ $item->variasi ?? '-' }}</small>
                                    </div>
                                    <div class="product-quantity">
                                        <span class="quantity-badge">x{{ $item->jumlah }}</span>
                                    </div>
                                </div>
                                <div class="product-price text-end">
                                    <div class="price fw-bold">Rp{{ number_format($item->harga, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-box text-muted" style="font-size: 3rem;"></i>
                        <p class="text-muted mt-2">Tidak ada produk pada pesanan ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Ringkasan Pembayaran -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h5 class="mb-3 fw-bold">
                    <i class="bi bi-receipt text-success me-2"></i>Rincian Pembayaran
                </h5>
                <div class="payment-summary">
                    <div class="summary-row">
                        <span class="summary-label">Subtotal Produk</span>
                        <span class="summary-value">Rp{{ number_format($subtotal ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span class="summary-label">Subtotal Pengiriman</span>
                        <span class="summary-value">Rp{{ number_format($ongkir ?? 0, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row total-row">
                        <span class="summary-label fw-bold">Total Pesanan</span>
                        <span class="summary-value fw-bold text-danger fs-5">Rp{{ number_format($total ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Button -->
        <div class="text-center mb-4">
            @if($pesanan->status == 'dikirim')
                <form action="{{ route('pesanan.terima', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-lg px-5 py-3">
                        <i class="bi bi-check-circle-fill me-2"></i>Pesanan Telah Diterima
                    </button>
                </form>
            @elseif($pesanan->status == 'selesai' && !$pesanan->sudah_ulasan)
                <form action="{{ route('ulasan.store', $pesanan->id_pesanan) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="ulasan" id="ulasan" class="form-control" rows="4" placeholder="Bagikan pengalaman Anda dengan produk ini..." required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-send-fill me-2"></i>Kirim Ulasan
                    </button>
                </form>
            @elseif($pesanan->status == 'selesai' && $pesanan->sudah_ulasan)
                <div class="alert alert-success d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span>Terima kasih, ulasan Anda sudah kami terima.</span>
                </div>
            @endif
        </div>

        <!-- Back to Home -->
        <div class="text-center">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Beranda
            </a>
        </div>
    </div>

    @include('user.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>

</html>