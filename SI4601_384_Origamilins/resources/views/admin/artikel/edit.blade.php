@extends('admin.layouts.app')

@section('title', 'Edit Artikel')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Edit Artikel</h2>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.artikel.update', $artikel->id_artikel) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul', $artikel->judul) }}" required>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                    <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                           id="tanggal_publikasi" name="tanggal_publikasi" 
                           value="{{ old('tanggal_publikasi', $artikel->tanggal_publikasi->format('Y-m-d')) }}" required>
                    @error('tanggal_publikasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Artikel</label>
                    <textarea class="form-control @error('isi') is-invalid @enderror" 
                              id="editor" name="isi" rows="10" required>{{ old('isi', $artikel->isi) }}</textarea>
                    @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="images" class="form-label">Gambar Artikel</label>
                    <input type="file" class="form-control @error('images.*') is-invalid @enderror" 
                           id="images" name="images[]" accept="image/jpeg,image/jpg,image/png" multiple>
                    <div class="form-text">Upload gambar baru (format: JPEG, JPG, PNG. Max: 2MB per gambar)</div>
                    @error('images.*')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                @if($artikel->images->count() > 0)
                <div class="mb-3">
                    <label class="form-label">Gambar Saat Ini</label>
                    <div class="d-flex flex-wrap gap-3">
                        @foreach($artikel->images as $image)
                        <div class="position-relative">
                            <img src="{{ url($image->image_path) }}" alt="Current Image" class="current-image">
                            <div class="mt-2">
                                <button type="button" class="btn btn-danger btn-sm delete-image" data-image-id="{{ $image->id }}">
                                    <i class="fas fa-trash"></i> Hapus
                                </button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <div id="image-preview" class="mb-3 d-flex flex-wrap gap-3"></div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Artikel
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.preview-image, .current-image {
    width: 300px;
    height: 200px;
    object-fit: cover;
    border-radius: 8px;
}

.ck-editor__editable_inline {
    min-height: 400px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script>
<script>
ClassicEditor
    .create(document.querySelector('#editor'), {
        toolbar: {
            items: [
                'heading', '|',
                'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                'bulletedList', 'numberedList', 'todoList', '|',
                'outdent', 'indent', '|',
                'alignment', '|',
                'link', 'insertImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                'undo', 'redo'
            ],
            shouldNotGroupWhenFull: true
        },
        language: 'id'
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
            const previewContainer = document.createElement('div');
            previewContainer.className = 'position-relative';
            previewContainer.innerHTML = `<img src="${e.target.result}" class="preview-image" alt="Preview">`;
            preview.appendChild(previewContainer);
        }
        reader.readAsDataURL(file);
    });
});

document.querySelectorAll('.delete-image').forEach(button => {
    button.addEventListener('click', function() {
        const imageId = this.dataset.imageId;
        if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_images[]';
            input.value = imageId;
            this.closest('form').appendChild(input);
            this.closest('.position-relative').remove();
        }
    });
});
</script>
@endpush
