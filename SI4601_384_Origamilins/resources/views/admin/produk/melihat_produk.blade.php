@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid mt-1">
    <h2 class="mb-4">Katalog Produk</h2>

    @if ($products->isEmpty())
        <div class="alert alert-warning" role="alert">
            Tidak ada produk yang tersedia.
        </div>
    @else
        <div class="row">
            @foreach ($products as $produk)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($produk->gambar)
                            @if(Str::startsWith($produk->gambar, 'http'))
                                <img src="{{ $produk->gambar }}" class="card-img-top" alt="{{ $produk->nama }}" style="height: 200px; object-fit: cover;">
                            @else
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}" style="height: 200px; object-fit: cover;">
                            @endif
                        @else
                            <div class="text-center p-4 bg-light">
                                <span class="text-muted">Tidak ada gambar</span>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <p class="card-text text-primary fw-bold">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <p class="card-text"><small class="text-muted">Kategori: {{ $produk->kategori }}</small></p>
                            <p class="card-text">{{ Str::limit($produk->deskripsi, 100) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
