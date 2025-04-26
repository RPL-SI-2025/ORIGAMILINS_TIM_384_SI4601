@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Tambah Event</h2>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mb-3">
                    <label for="nama_event" class="form-label">Nama Event</label>
                    <input type="text" class="form-control @error('nama_event') is-invalid @enderror" 
                           id="nama_event" name="nama_event" value="{{ old('nama_event') }}" required>
                    @error('nama_event')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                              id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                    <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" 
                           id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" value="{{ old('tanggal_pelaksanaan') }}" required>
                    @error('tanggal_pelaksanaan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                           id="lokasi" name="lokasi" value="{{ old('lokasi') }}" required>
                    @error('lokasi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                               id="harga" name="harga" value="{{ old('harga', 0) }}" required min="0">
                    </div>
                    @error('harga')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="kuota" class="form-label">Kuota Peserta</label>
                    <input type="number" class="form-control @error('kuota') is-invalid @enderror" 
                           id="kuota" name="kuota" value="{{ old('kuota', 0) }}" required min="1">
                    @error('kuota')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        Masukkan jumlah maksimal peserta yang dapat mengikuti event ini
                    </div>
                </div>

                <div class="mb-3">
                    <label for="poster" class="form-label">Poster Event</label>
                    <input type="file" class="form-control @error('poster') is-invalid @enderror" 
                           id="poster" name="poster" accept="image/*" required>
                    <div class="form-text">Format: JPG, JPEG, PNG (Maks. 2MB)</div>
                    @error('poster')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div id="poster-preview" class="mt-2 d-none">
                        <img src="" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                    </div>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Event
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('poster').onchange = function(evt) {
    const [file] = this.files;
    if (file) {
        const preview = document.getElementById('poster-preview');
        preview.classList.remove('d-none');
        preview.querySelector('img').src = URL.createObjectURL(file);
    }
};
</script>

<style>
.form-label {
    font-weight: 500;
}

.invalid-feedback {
    display: block;
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    padding: 0.25rem;
    background-color: #fff;
    border-radius: 0.25rem;
    object-fit: contain;
}
</style>
@endsection 