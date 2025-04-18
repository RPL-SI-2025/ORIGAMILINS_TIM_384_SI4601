@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <h4 class="mb-4">Tambah Produk Baru</h4>
    
    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                @error('nama')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-6">
                <select class="form-select" id="kategori" name="kategori">
                    <option selected disabled>Pilih Kategori</option>
                    <option value="Dekorasi" {{ old('kategori') == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                    <option value="Aksesoris" {{ old('kategori') == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    <option value="Lainnya" {{ old('kategori') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('kategori')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="harga" class="col-sm-2 col-form-label">Harga</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga') }}">
                </div>
                @error('harga')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="gambar" class="col-sm-2 col-form-label">Gambar Produk</label>
            <div class="col-sm-6">
                <input type="file" class="form-control" id="gambar" name="gambar">
                <div class="form-text">Format: JPG, PNG, JPEG, GIF (Maks. 2MB)</div>
                @error('gambar')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-6">
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <a href="{{ route('produk.melihat_produk') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-success">Simpan Produk</button>
            </div>
        </div>
    </form>
</div>
@endsection