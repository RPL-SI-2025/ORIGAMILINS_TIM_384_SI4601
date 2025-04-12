@extends('layouts.app')

@php
    use Illuminate\Support\Str;
@endphp


@section('content')
<div class="container-fluid mt-1">
    
    <h2 class="mb-4">Daftar Produk</h2>

    @if ($products->isEmpty())
        <div class="alert alert-warning" role="alert">
            Tidak ada produk yang tersedia.
        </div>
    @else
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Gambar</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($products as $produk)
                <tr>
                    <td>
                        @if($produk->gambar)
                            @if(Str::startsWith($produk->gambar, 'http'))
                                <img src="{{ $produk->gambar }}" alt="{{ $produk->nama }}" class="img-thumbnail" width="80">
                            @else
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="img-thumbnail" width="80">
                            @endif
                        @else
                            <span class="text-muted">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td>{{ $produk->nama }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->kategori }}</td>
                    <td>
                        <div style="max-width: 300px; white-space: normal;">
                            {{ $produk->deskripsi }}
                        </div>
                    </td>
                    <td>
                        <a href="#" class="btn btn-info btn-sm">Lihat</a>
                        <a href="#" class="btn btn-warning btn-sm">Edit</a>
                        <form action="#" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
