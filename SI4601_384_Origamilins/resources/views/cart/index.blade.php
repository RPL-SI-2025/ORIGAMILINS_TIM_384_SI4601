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