@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4 py-3">
    <h4 class="mb-4">Tambah Produk Baru</h4>
    
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
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
                <select class="form-select" id="kategori" name="kategori" onchange="updateUkuranOptions()">
                    <option selected disabled>Pilih Kategori</option>
                    <option value="Dekorasi" {{ old('kategori') == 'Dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                    <option value="Merchandise" {{ old('kategori') == 'Merchandise' ? 'selected' : '' }}>Merchandise</option>
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
                           value="{{ old('harga_dasar') }}"
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
                <a href="{{ route('admin.produk.index') }}" class="btn btn-light me-2">Batal</a>
                <button type="submit" class="btn btn-success">Simpan Produk</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function formatRupiah(angka) {
    angka = angka.replace(/\D/g, '');
    return angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function updateUkuranOptions() {
    const kategori = document.getElementById('kategori').value;
    const ukuranContainer = document.getElementById('ukuran-container').querySelector('.row');
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
                    <input class="form-check-input" type="checkbox" name="ukuran[]" value="${ukuran}" id="ukuran-${ukuran.replace(/\s+/g, '-')}">
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
                    <input class="form-check-input" type="checkbox" name="ukuran[]" value="${ukuran}" id="ukuran-${ukuran.replace(/\s+/g, '-')}">
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