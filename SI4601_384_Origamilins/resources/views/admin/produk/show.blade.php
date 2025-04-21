@extends('admin.layouts.app')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Detail Produk</h2>
        <a href="{{ route('admin.produk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->gambar)
                        @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                            <img src="{{ $product->gambar }}" alt="{{ $product->nama }}" class="img-fluid rounded">
                        @else
                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="img-fluid rounded">
                        @endif
                    @else
                        <div class="text-center p-4 bg-light rounded">
                            <span class="text-muted">Tidak ada gambar</span>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px">Nama Produk</th>
                            <td>{{ $product->nama }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $product->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Stok</th>
                            <td>
                                <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stok }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $product->deskripsi }}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Produk
                        </a>
                        <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                <i class="fas fa-trash"></i> Hapus Produk
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
