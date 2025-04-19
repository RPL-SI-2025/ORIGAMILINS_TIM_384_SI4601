@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Tambah Artikel</h2>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                    <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                           id="tanggal_publikasi" name="tanggal_publikasi" value="{{ old('tanggal_publikasi') }}" required>
                    @error('tanggal_publikasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Artikel</label>
                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                              id="editor" name="isi" rows="10" required>{{ old('isi') }}</textarea>
                    @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Gambar Artikel</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                           id="images" name="images[]" accept="image/jpeg,image/jpg,image/png" multiple>
                    <div class="form-text">Upload satu atau lebih gambar (format: JPEG, JPG, PNG. Max: 2MB per gambar)</div>
                    @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="image-preview" class="mb-3 d-flex flex-wrap gap-2"></div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Artikel
                </button>
            </form>
        </div>
    </div>
</div>

<style>
.preview-image {
    max-width: 300px;
    max-height: 300px;
    object-fit: contain;
    border-radius: 8px;
    margin-top: 10px;
}

.ck-editor__editable_inline {
    min-height: 400px;
}
</style>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|', 'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'],
        heading: {
            options: [
                { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
            ]
        }
    })
    .catch(error => {
        console.error(error);
    });

document.getElementById('images').addEventListener('change', function(event) {
    const preview = document.getElementById('image-preview');
    preview.innerHTML = '';
    
    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgContainer = document.createElement('div');
            imgContainer.innerHTML = `
                <img src="${e.target.result}" class="preview-image" alt="Preview">
            `;
            preview.appendChild(imgContainer);
        }
        reader.readAsDataURL(file);
    });
});
</script>
@endpush
@endsection