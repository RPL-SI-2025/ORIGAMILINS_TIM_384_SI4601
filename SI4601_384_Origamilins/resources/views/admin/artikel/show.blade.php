@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Detail Artikel</h2>
        <a href="{{ route('admin.artikel.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-8">
                    <h3 class="article-title">{{ $artikel->judul }}</h3>
                    <div class="article-meta text-muted mb-4">
                        <span><i class="fas fa-calendar me-2"></i>{{ $artikel->tanggal_publikasi->isoFormat('dddd, D MMMM Y') }}</span>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Artikel
                    </a>
                    <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                            <i class="fas fa-trash"></i> Hapus Artikel
                        </button>
                    </form>
                </div>
            </div>

            @if($artikel->gambar)
            <div class="article-image mb-4">
                <img src="{{ asset($artikel->gambar) }}" class="img-fluid rounded" alt="Gambar Artikel {{ $artikel->judul }}">
            </div>
            @endif

            <div class="article-content">
                {!! $artikel->isi !!}
            </div>
        </div>
    </div>
</div>

<style>
.article-title {
    color: #333;
    font-weight: 600;
    margin-bottom: 1rem;
}

.article-meta {
    font-size: 0.9rem;
}

.article-content {
    line-height: 1.8;
    color: #444;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1rem 0;
}

.article-content table {
    width: 100%;
    margin: 1rem 0;
    border-collapse: collapse;
}

.article-content table td,
.article-content table th {
    border: 1px solid #dee2e6;
    padding: 0.75rem;
}

.article-image {
    background-color: #f8f9fa;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
}

.article-image img {
    max-width: 100%;
    max-height: 400px;
    object-fit: contain;
    margin: 0 auto;
}

.btn {
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .btn {
        margin: 0.5rem;
        display: block;
        width: 100%;
    }

    .article-image img {
        max-height: 300px;
    }
}
</style>
@endsection
