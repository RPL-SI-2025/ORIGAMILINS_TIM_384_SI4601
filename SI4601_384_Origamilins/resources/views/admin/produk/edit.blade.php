@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <h4 class="mb-4">Edit Produk</h4>
    
    <form action="{{ route('admin.produk.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="row mb-3">
            <label for="nama" class="col-sm-2 col-form-label">Nama Produk</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $product->nama) }}">
                @error('nama')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="kategori" class="col-sm-2 col-form-label">Kategori</label>
            <div class="col-sm-6">
                <select class="form-select" id="kategori" name="kategori">
                    <option disabled>Pilih Kategori</option>
                    <option value="Dekorasi" {{ old('kategori', $product->kategori) == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                    <option value="Aksesoris" {{ old('kategori', $product->kategori) == 'Aksesoris' ? 'selected' : '' }}>Aksesoris</option>
                    <option value="Lainnya" {{ old('kategori', $product->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                    <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $product->harga) }}">
                </div>
                @error('harga')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="gambar" class="col-sm-2 col-form-label">Gambar Produk</label>
            <div class="col-sm-6">
                @if($product->gambar)
                    <div class="mb-2">
                        <img src="{{ filter_var($product->gambar, FILTER_VALIDATE_URL) ? $product->gambar : asset('storage/' . $product->gambar) }}" 
                             alt="Current Image" 
                             class="img-thumbnail" 
                             style="max-width: 200px;">
                    </div>
                @endif
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
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                @error('deskripsi')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-sm-10 offset-sm-2">
                <a href="{{ route('admin.produk.index') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-success">Update Produk</button>
            </div>
        </div>
    </form>
</div>
@endsection 