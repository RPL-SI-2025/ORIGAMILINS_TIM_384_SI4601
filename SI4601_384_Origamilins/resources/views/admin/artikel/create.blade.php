@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Tambah Artikel</h2>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.artikel.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul Artikel</label>
                    <input type="text" class="form-control @error('judul') is-invalid @enderror" 
                           id="judul" name="judul" value="{{ old('judul') }}" required>
                    <div class="form-text">Judul hanya boleh berisi huruf, spasi, dan tanda hubung (-)</div>
                    @error('judul')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="tanggal_publikasi" class="form-label">Tanggal Publikasi</label>
                    <input type="date" class="form-control @error('tanggal_publikasi') is-invalid @enderror" 
                           id="tanggal_publikasi" name="tanggal_publikasi" 
                           value="{{ old('tanggal_publikasi', date('Y-m-d')) }}" 
                           max="{{ date('Y-m-d') }}" required>
                    <div class="form-text">Tanggal publikasi tidak boleh lebih dari hari ini</div>
                    @error('tanggal_publikasi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="isi" class="form-label">Isi Artikel</label>
                    <div class="editor-container">
                        <textarea class="form-control @error('isi') is-invalid @enderror" 
                                id="editor" name="isi">{{ old('isi') }}</textarea>
                    </div>
                    <div class="form-text">Isi artikel minimal 50 karakter</div>
                    @error('isi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Gambar Artikel</label>
                    <input type="file" class="form-control @error('gambar') is-invalid @enderror" 
                           id="gambar" name="gambar" accept="image/jpeg,image/jpg,image/png">
                    <div class="form-text">Upload gambar (format: JPEG, JPG, PNG. Max: 2MB)</div>
                    @error('gambar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div id="image-preview" class="mb-3"></div>

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
}

.editor-container {
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.ck.ck-editor {
    width: 100% !important;
}

.ck-editor__editable_inline {
    min-height: 400px;
    max-height: 600px;
    overflow-y: auto;
}

.ck.ck-toolbar {
    border-radius: 4px 4px 0 0 !important;
    border-bottom: 1px solid #ddd !important;
    background: #f8f9fa !important;
}

.ck.ck-content {
    border-radius: 0 0 4px 4px !important;
    border: none !important;
    border-top: none !important;
}

.ck-content table {
    border-collapse: collapse;
    margin: 1em 0;
}

.ck-content table td,
.ck-content table th {
    border: 1px solid #bbb;
    padding: 0.4em;
}

.ck-content figure.image {
    margin: 1em 0;
}

.ck-content figure.image img {
    max-width: 100%;
    height: auto;
}

.ck-content figure.image-style-side {
    float: right;
    margin-left: 1.5em;
    max-width: 50%;
}

.ck-content figure.image-style-align-left {
    float: left;
    margin-right: 1.5em;
}

.ck-content figure.image-style-align-center {
    margin-left: auto;
    margin-right: auto;
}
</style>

@push('scripts')
<script src="https://cdn.ckeditor.com/ckeditor5/40.1.0/super-build/ckeditor.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
            language: 'id',
            image: {
                toolbar: [
                    'imageTextAlternative',
                    'imageStyle:inline',
                    'imageStyle:block',
                    'imageStyle:side'
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });

    document.getElementById('gambar').addEventListener('change', function(event) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
        
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'preview-image';
                preview.appendChild(img);
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    });
});
</script>
@endpush
@endsection
