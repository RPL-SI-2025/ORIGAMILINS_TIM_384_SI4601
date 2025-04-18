@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Detail Event</h2>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow-sm">
                <div class="card-body text-center">
                    @if($event->poster)
                    <img src="{{ url($event->poster) }}" alt="Poster {{ $event->nama_event }}" 
                         class="img-fluid rounded mb-3" style="max-height: 400px; width: auto;">
                    @else
                    <div class="no-poster-placeholder">
                        <i class="fas fa-image fa-4x text-muted"></i>
                        <p class="mt-2">Tidak ada poster</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <table class="table table-details">
                        <tr>
                            <th width="200">Nama Event</th>
                            <td>{{ $event->nama_event }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaksanaan</th>
                            <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->isoFormat('dddd, D MMMM Y') }}</td>
                        </tr>
                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $event->lokasi }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{!! nl2br(e($event->deskripsi)) !!}</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Event
                        </a>
                        <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                <i class="fas fa-trash"></i> Hapus Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.table-details th {
    background-color: #f8f9fa;
}

.table-details td, .table-details th {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.no-poster-placeholder {
    padding: 2rem;
    background-color: #f8f9fa;
    border-radius: 0.25rem;
}

.card {
    border: none;
}

.shadow-sm {
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075)!important;
}

.btn {
    margin-right: 0.5rem;
}
</style>
@endsection 