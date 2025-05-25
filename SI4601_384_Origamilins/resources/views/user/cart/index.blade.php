<<<<<<< HEAD
<<<<<<< HEAD
=======
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
@extends('user.layouts.etalase')

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
                    </div>
                    @endforeach
                </div>
                <div class="col-lg-4">
                    <div class="bg-white rounded-4 p-4 shadow-sm">
                        <h5 class="card-title">Ringkasan Belanja</h5>
                        <hr>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal:</span>
                            <span class="subtotal-cart">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Biaya Pengiriman:</span>
                            <span>Rp 0</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong>Total Pembayaran:</strong>
                            <strong class="total-cart">Rp {{ number_format($total, 0, ',', '.') }}</strong>
                        </div>
                        <button id="checkout-btn" class="btn btn-success btn-lg w-100" disabled>Checkout</button>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Pilih semua
    $('#select-all-cart').on('change', function() {
        $('.cart-item-checkbox').prop('checked', $(this).is(':checked'));
        toggleCheckoutButton();
    });
    $(document).on('change', '.cart-item-checkbox', function() {
        $('#select-all-cart').prop('checked', $('.cart-item-checkbox:checked').length === $('.cart-item-checkbox').length);
        toggleCheckoutButton();
    });
    function toggleCheckoutButton() {
        $('#checkout-btn').prop('disabled', $('.cart-item-checkbox:checked').length === 0);
    }
    toggleCheckoutButton();
    // Submit checkout hanya produk terpilih
    $('#checkout-btn').on('click', function(e) {
        e.preventDefault();
        if($('.cart-item-checkbox:checked').length === 0) {
            alert('Pilih minimal satu produk untuk checkout!');
            return;
        }
        $('#checkout-form').submit();
    });
    // Handle quantity updates
    $('.update-quantity').on('change', function() {
        const produkId = $(this).data('produk-id');
        const jumlah = $(this).val();
        const $itemRow = $(this).closest('.bg-white.rounded-4');
        const $subtotalProduk = $itemRow.find('.subtotal-produk b');

        $.post('/cart/update', {
            produk_id: produkId,
            jumlah: jumlah
        })
        .done(function(response) {
            // Update subtotal produk jika ada di response
            if(response.new_subtotal !== undefined) {
                $subtotalProduk.text('Rp ' + Number(response.new_subtotal).toLocaleString('id-ID'));
            }
            // Update total cart jika ada di response
            if(response.new_total !== undefined) {
                $('.subtotal-cart, .total-cart').text('Rp ' + Number(response.new_total).toLocaleString('id-ID'));
            }
            // Update cart badge jika ada cartCount
            if(response.cartCount !== undefined) {
                $('#cart-badge').text(response.cartCount);
            }
        })
        .fail(function(xhr) {
            alert('Terjadi kesalahan saat memperbarui jumlah: ' + (xhr.responseJSON.message || ''));
        });
    });

    // Handle product removal
    $('.remove-produk').on('click', function() {
        if (!confirm('Apakah Anda yakin ingin menghapus produk ini dari keranjang?')) {
            return;
        }

        const produkId = $(this).data('produk-id');
        const $itemCard = $(this).closest('.bg-white.rounded-4');

        $.post('/cart/remove', {
            produk_id: produkId
        })
        .done(function(response) {
            $itemCard.remove();
            // Update total pembayaran
            if(response.new_total !== undefined) {
                $('.subtotal-cart, .total-cart').text('Rp ' + Number(response.new_total).toLocaleString('id-ID'));
            }
            // Update cart badge jika ada cartCount di response
            if(response.cartCount !== undefined) {
                $('#cart-badge').text(response.cartCount);
            }
            // Jika cart kosong, tampilkan pesan kosong
            if ($('.col-lg-8 .bg-white.rounded-4').length === 0) {
                $('.container > .row, .container-fluid > .row').hide();
                $('.container, .container-fluid').append('<div class="alert alert-info text-center" role="alert"><i class="fas fa-shopping-cart fa-2x mb-3"></i><br>Keranjang Anda masih kosong<br><br><a href="{{ route('etalase') }}" class="btn btn-primary">Mulai Belanja</a></div>');
            }
        })
        .fail(function(xhr) {
            alert('Terjadi kesalahan saat menghapus produk: ' + (xhr.responseJSON.message || ''));
        });
    });

    function updateSummaryByChecked() {
        let total = 0;
        $('.cart-item-checkbox:checked').each(function() {
            total += parseFloat($(this).data('subtotal'));
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
<<<<<<< HEAD
@endsection
=======
@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Keranjang Saya</h1>
    @if (isset($message) && $message == 'Keranjang Anda masih kosong')
        <p>{{ $message }}</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th> Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td> Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                        <td>
                            <input type="number" min="1" value="{{ $item->jumlah }}" data-produk-id="{{ $item->produk_id }}" class="update-quantity" />
                        </td>
                        <td> Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <button class="btn btn-danger remove-produk" data-produk-id="{{ $item->produk_id }}">Hapus</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right;"><strong>Total Harga:</strong></td>
                    <td colspan="2"> Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>
    @endif
</div>

<script>
    document.querySelectorAll('.remove-produk').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            const produkId = e.target.dataset.produkId;
            if (confirm("Apakah Anda yakin ingin menghapus produk ini dari keranjang?")) {
                fetch('/cart/remove', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }, body: JSON.stringify({ produk_id: produkId }) })
                    .then(resp => resp.json())
                    .then(data => { alert(data.message); location.reload(); })
                    .catch(err => console.error(err));
            }
        });
    });
    document.querySelectorAll('.update-quantity').forEach(input => {
        input.addEventListener('change', (e) => {
            const produkId = e.target.dataset.produkId;
            const jumlah = e.target.value;
            fetch('/cart/update', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json' }, body: JSON.stringify({ produk_id: produkId, jumlah: jumlah }) })
                .then(resp => resp.json())
                .then(data => { alert(data.message); location.reload(); })
                .catch(err => console.error(err));
        });
    });
</script>
@endsection 
>>>>>>> 067a531 (Cart Sementara)
=======
@endsection
>>>>>>> fa94269c81f6bb757422f1f6a9b2cd8607abca47
