@extends('user.navigation-menu')
@section('content')
<div class="container-fluid py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-3">
        <ol class="breadcrumb bg-transparent p-0">
            <li class="breadcrumb-item"><a href="/etalase-produk" style="color:#0835d8;">Home</a></li>
            <li class="breadcrumb-item"><a href="#" style="color:#0835d8;">{{ $product->kategori }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->nama }}</li>
        </ol>
    </nav>
    <div class="row g-4">
        <!-- Gambar Produk -->
        <div class="col-lg-6">
            <div class="bg-white rounded-4 p-4 d-flex flex-column align-items-center shadow-sm">
                <img src="{{ $product->gambar ? (filter_var($product->gambar, FILTER_VALIDATE_URL) ? $product->gambar : asset($product->gambar)) : asset('no-image.png') }}" alt="{{ $product->nama }}" class="img-fluid rounded-3 mb-3" style="max-height:340px; object-fit:contain;">
                <div class="d-flex justify-content-center mt-2">
                    <img src="{{ $product->gambar ? (filter_var($product->gambar, FILTER_VALIDATE_URL) ? $product->gambar : asset($product->gambar)) : asset('no-image.png') }}" class="img-thumbnail active" alt="{{ $product->nama }}">
                </div>
                <div class="d-flex gap-2 mt-3">
                    <button class="btn btn-outline-secondary btn-sm"><i class="far fa-heart"></i> Wishlist</button>
                </div>
            </div>
        </div>
        <!-- Info Produk -->
        <div class="col-lg-6">
            <div class="bg-white rounded-4 p-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                <div>
                    <h1 class="fw-bold mb-2" style="color:#0835d8; font-size:2rem;">{{ $product->nama }}</h1>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <span class="fs-3 fw-bold text-success">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                        @if($product->harga_diskon)
                            <span class="badge bg-danger">-{{ round(100-($product->harga/$product->harga_diskon*100)) }}%</span>
                            <span class="text-muted text-decoration-line-through ms-2">Rp {{ number_format($product->harga_diskon, 0, ',', '.') }}</span>
                        @endif
                    </div>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <span class="badge bg-primary">{{ $product->kategori }}</span>
                        @if($product->stok !== null)
                            <span class="badge bg-warning text-dark">Stok: {{ $product->stok }}</span>
                        @endif
                    </div>
                    <div class="mb-2 d-flex align-items-center gap-2">
                        <span class="text-warning"><i class="fas fa-star"></i> Belum ada rating</span>
                        <span class="text-muted">(0 ulasan) | 0 terjual</span>
                    </div>
                    <hr class="my-3">
                    <div class="mb-2 small text-muted">
                        <div><b>Kondisi:</b> Baru</div>
                        <div><b>Min. Pembelian:</b> 1 buah</div>
                        <div><b>Etalase:</b> {{ $product->kategori }}</div>
                    </div>
                    <div class="mb-2 small text-muted">
                        <b>Penjual:</b> <span class="fw-bold" style="color:#0835d8;">Origamilins Official</span>
                        <span class="badge bg-success ms-2">Terverifikasi</span>
                    </div>
                    <hr class="my-3">
                    <div class="mb-3">
                        <strong>Deskripsi Produk:</strong>
                        <div class="text-muted">{!! nl2br(e($product->deskripsi)) !!}</div>
                    </div>
                </div>
                <div class="d-flex gap-2 mt-4">
                    <div class="mb-3">
                        <label for="quantity" class="form-label"><b>Jumlah:</b></label>
                        <div class="input-group" style="max-width: 200px;">
                            <button class="btn btn-outline-secondary" type="button" onclick="decrementQuantity()">-</button>
                            <input type="number" class="form-control text-center" id="quantity" value="1" min="1" max="{{ $product->stok ?? 999 }}">
                            <button class="btn btn-outline-secondary" type="button" onclick="incrementQuantity()">+</button>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" onclick="addToCart()">
                            <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                        </button>
                        <button class="btn btn-success btn-lg">
                            <i class="fas fa-bolt me-2"></i>Beli Langsung
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('styles')
<style>
    .rounded-4 { border-radius: 1.5rem !important; }
    .img-thumbnail { max-width: 80px; max-height: 80px; object-fit: cover; border-radius: 0.75rem; border:2px solid #eee; margin-right: 8px; }
    .img-thumbnail.active { border:2px solid #0835d8; }
    .breadcrumb { font-size: 1rem; background: none; }
    .breadcrumb-item + .breadcrumb-item::before { color: #bbb; }
    .shadow-sm { box-shadow: 0 2px 8px rgba(8,53,216,0.06) !important; }
</style>
@endpush
@push('scripts')
<script>
function incrementQuantity() {
    const input = document.getElementById('quantity');
    const max = parseInt(input.getAttribute('max'));
    const currentValue = parseInt(input.value);
    if (currentValue < max) {
        input.value = currentValue + 1;
    }
}

function decrementQuantity() {
    const input = document.getElementById('quantity');
    const currentValue = parseInt(input.value);
    if (currentValue > 1) {
        input.value = currentValue - 1;
    }
}

function addToCart() {
    const quantity = document.getElementById('quantity').value;
    
    $.ajax({
        url: '/cart/add',
        method: 'POST',
        data: {
            produk_id: {{ $product->id }},
            jumlah: quantity
        },
        success: function(response) {
            alert(response.message);
            // Optionally refresh the page or update cart count
            window.location.reload();
        },
        error: function(xhr) {
            if (xhr.status === 401) {
                window.location.href = '/login';
            } else {
                alert('Terjadi kesalahan saat menambahkan ke keranjang');
            }
        }
    });
}
</script>
@endpush
@endsection 