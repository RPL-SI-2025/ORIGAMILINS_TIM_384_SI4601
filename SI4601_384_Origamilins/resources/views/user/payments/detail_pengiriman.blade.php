@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Invoice Pemesanan</h4>
                </div>
                <div class="card-body">
                    <h5 class="mb-3">Detail Produk</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $item)
                            <tr>
                                <td>
                                    {{ $item->produk->nama ?? '-' }}
                                    <br>
                                    <small class="text-muted">{{ $item->produk->spesifikasi ?? '' }}</small>
                                </td>
                                <td>{{ 'Rp ' . number_format($item->produk->harga ?? 0, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah ?? 1 }}</td>
                                <td>{{ 'Rp ' . number_format(($item->produk->harga ?? 0) * ($item->jumlah ?? 1), 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <hr>
                    <h5 class="mb-3">Alamat Pengiriman</h5>
                    <div>
                        <strong>{{ $alamat['nama_awal'] ?? '' }} {{ $alamat['nama_akhir'] ?? '' }}</strong><br>
                        {{ $alamat['alamat'] ?? '' }}<br>
                        Blok/Gang/Unit/No: {{ $alamat['blok_gang'] ?? '' }}<br>
                        Kecamatan: {{ $alamat['kecamatan'] ?? '' }}<br>
                        Kota/Kabupaten: {{ $alamat['kota'] ?? '' }}<br>
                        Provinsi: {{ $alamat['provinsi'] ?? '' }}<br>
                        Kode Pos: {{ $alamat['kode_pos'] ?? '' }}<br>
                        No. HP: {{ $alamat['country_code'] ?? '' }}{{ $alamat['phone'] ?? '' }}
                    </div>
                    <hr>
                    <h5 class="mb-3">Ringkasan Pembayaran</h5>
                    <table class="table">
                        <tr>
                            <th>Subtotal</th>
                            <td class="text-end">{{ 'Rp ' . number_format($subtotal ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Ongkir ({{ $alamat['shipping_method'] ?? '' }})</th>
                            <td class="text-end">{{ 'Rp ' . number_format($ongkir ?? 0, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Total</th>
                            <td class="text-end fw-bold">{{ 'Rp ' . number_format($total ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                    <div class="d-flex justify-content-end mt-4">
                        <form action="{{ route('user.payments.pay') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                Lanjut ke Pembayaran <i class="fas fa-arrow-right ms-2"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection