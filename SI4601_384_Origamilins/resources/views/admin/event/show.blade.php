@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Detail Event</h2>
        <div>
            <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <tr>
                            <th style="width: 200px;">Nama Event</th>
                            <td>{{ $event->nama_event }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $event->deskripsi }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaksanaan</th>
                            <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
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
                            <th>Kuota Peserta</th>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="progress" style="width: 200px; height: 25px;">
                                        <div class="progress-bar {{ $event->kuota_terisi >= $event->kuota ? 'bg-danger' : 'bg-success' }}" 
                                             role="progressbar" 
                                             style="width: {{ ($event->kuota_terisi / $event->kuota) * 100 }}%">
                                            {{ $event->kuota_terisi }}/{{ $event->kuota }}
                                        </div>
                                    </div>
                                    <span class="ms-3">
                                        @if($event->tanggal_pelaksanaan < now())
                                            <span class="badge bg-secondary">Selesai</span>
                                        @else
                                            @if($event->kuota_terisi >= $event->kuota)
                                                <span class="badge bg-danger">Full</span>
                                            @else
                                                <span class="badge bg-success">Tersedia</span>
                                            @endif
                                        @endif
                                    </span>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Poster Event</h5>
                        </div>
                        <div class="card-body">
                            @if($event->poster)
                                <img src="{{ Storage::url($event->poster) }}" alt="Poster {{ $event->nama_event }}" 
                                     class="img-fluid rounded">
                            @else
                                <div class="alert alert-info mb-0">
                                    Tidak ada poster
                                </div>
                            @endif
                        </div>
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