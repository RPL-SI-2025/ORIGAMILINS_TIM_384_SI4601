@extends('admin.layouts.app')

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
                <select class="form-select" id="kategori" name="kategori" onchange="updateUkuranOptions()">
                    <option selected disabled>Pilih Kategori</option>
                    <option value="Dekorasi" {{ old('kategori', $product->kategori) == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                    <option value="Merchandise" {{ old('kategori', $product->kategori) == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
                </select>
                @error('kategori')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="harga_dasar" class="col-sm-2 col-form-label">Harga Dasar</label>
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control" id="harga_dasar" name="harga_dasar" 
                           value="{{ old('harga_dasar', number_format($product->harga_dasar, 0, ',', '.')) }}"
                           oninput="this.value = formatRupiah(this.value)" placeholder="0">
                </div>
                <div class="form-text">Harga untuk ukuran terkecil (5x5 cm untuk Merchandise, 1 meter untuk Dekorasi)</div>
                @error('harga_dasar')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Ukuran</label>
            <div class="col-sm-6">
                <div id="ukuran-container" class="border rounded p-3">
                    <div class="row g-3">
                        <!-- Ukuran options will be populated here -->
                    </div>
                </div>
                <div class="form-text">Harga akan dihitung otomatis berdasarkan ukuran yang dipilih</div>
                @error('ukuran')
                    <span class="text-danger small">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="row mb-3">
            <label for="stok" class="col-sm-2 col-form-label">Stok</label>
            <div class="col-sm-6">
                <input type="number" class="form-control" id="stok" name="stok" 
                       value="{{ old('stok', $product->stok) }}" min="0">
                @error('stok')
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

@push('scripts')
<script>
function formatRupiah(angka) {
    angka = angka.replace(/\D/g, '');
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

document.getElementById('harga_dasar').addEventListener('blur', function(e) {
    if (this.value !== '') {
        let nilai = parseInt(this.value.replace(/\./g, '')) || 0;
        this.value = formatRupiah(nilai.toString());
    }
});

function updateUkuranOptions() {
    const kategori = document.getElementById('kategori').value;
    const ukuranContainer = document.getElementById('ukuran-container').querySelector('.row');
    const currentUkuran = {!! json_encode(old('ukuran', $product->ukuran ? explode(',', $product->ukuran) : [])) !!};
    ukuranContainer.innerHTML = '';

    if (kategori === 'Merchandise') {
        const ukuranMerchandise = [
            '5 x 5 cm',
            '10 x 10 cm',
            '15 x 15 cm',
            '20 x 20 cm'
        ];
        ukuranMerchandise.forEach(ukuran => {
            const div = document.createElement('div');
            div.className = 'col-6 col-md-3';
            div.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ukuran[]" value="${ukuran}" id="ukuran-${ukuran.replace(/\s+/g, '-')}"
                        ${currentUkuran.includes(ukuran) ? 'checked' : ''}>
                    <label class="form-check-label" for="ukuran-${ukuran.replace(/\s+/g, '-')}">
                        ${ukuran}
                    </label>
                </div>
            `;
            ukuranContainer.appendChild(div);
        });
    } else if (kategori === 'Dekorasi') {
        const ukuranDekorasi = [
            '1 meter',
            '2 meter',
            '3 meter',
            '4 meter',
            '5 meter'
        ];
        ukuranDekorasi.forEach(ukuran => {
            const div = document.createElement('div');
            div.className = 'col-6 col-md-3';
            div.innerHTML = `
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="ukuran[]" value="${ukuran}" id="ukuran-${ukuran.replace(/\s+/g, '-')}"
                        ${currentUkuran.includes(ukuran) ? 'checked' : ''}>
                    <label class="form-check-label" for="ukuran-${ukuran.replace(/\s+/g, '-')}">
                        ${ukuran}
                    </label>
                </div>
            `;
            ukuranContainer.appendChild(div);
        });
    }
}

// Trigger on page load if kategori is already selected
document.addEventListener('DOMContentLoaded', function() {
    const kategori = document.getElementById('kategori').value;
    if (kategori) {
        updateUkuranOptions();
    }
});
</script>
@endpush
@endsection
