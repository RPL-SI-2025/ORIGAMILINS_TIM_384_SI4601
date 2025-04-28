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
                            <th>Harga Dasar</th>
                            <td>Rp {{ number_format($product->harga_dasar, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $product->kategori }}</td>
                        </tr>
                        <tr>
                            <th>Ukuran</th>
                            <td>
                                @php
                                    $ukuranArray = $product->ukuran ? explode(',', $product->ukuran) : [];
                                    $ukuranList = [];
                                    if($product->kategori == 'Merchandise') {
                                        $ukuranList = ['5 x 5 cm', '10 x 10 cm', '15 x 15 cm', '20 x 20 cm'];
                                    } else {
                                        $ukuranList = ['1 meter', '2 meter', '3 meter', '4 meter', '5 meter'];
                                    }
                                @endphp
                                @if(!empty($ukuranArray))
                                    @foreach($ukuranList as $ukuran)
                                        @if(in_array($ukuran, $ukuranArray))
                                            <span class="badge bg-info me-1">{{ $ukuran }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Tidak ada ukuran tersedia</span>
                                @endif
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
                        <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline" id="delete-form-detail">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger" onclick="confirmDelete('delete-form-detail')">
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
