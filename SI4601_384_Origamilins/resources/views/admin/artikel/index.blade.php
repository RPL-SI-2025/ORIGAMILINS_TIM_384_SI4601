@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Manajemen Artikel</h2>
        <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Artikel
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            @if($artikels->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Judul</th>
                            <th>Tanggal Publikasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($artikels as $index => $artikel)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                @if($artikel->gambar)
                                <img src="{{ $artikel->gambar }}" 
                                     alt="Gambar Artikel" 
                                     class="artikel-thumbnail">
                                @else
                                <span class="text-muted">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td>{{ $artikel->judul }}</td>
                            <td>{{ $artikel->tanggal_publikasi->isoFormat('D MMMM Y') }}</td>
                            <td>
                                <a href="{{ route('admin.artikel.show', $artikel->id_artikel) }}" 
                                   class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.artikel.edit', $artikel->id_artikel) }}" 
                                   class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.artikel.destroy', $artikel->id_artikel) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-4">
                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada artikel yang ditambahkan</p>
                <a href="{{ route('admin.artikel.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Tambah Artikel Pertama
                </a>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.artikel-thumbnail {
    width: 100px;
    height: 60px;
    object-fit: cover;
    border-radius: 4px;
}

.table th {
    background-color: #f8f9fa;
    border-bottom: 2px solid #dee2e6;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    margin: 0 0.1rem;
}

.alert {
    margin-bottom: 1.5rem;
}

.table-responsive {
    margin: 0;
    padding: 0;
}

.table td {
    vertical-align: middle;
}
</style>
@endsection 