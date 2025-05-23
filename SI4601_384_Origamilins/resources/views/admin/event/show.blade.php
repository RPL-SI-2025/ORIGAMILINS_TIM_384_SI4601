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
                            <th>Status Kuota</th>
                            <td>
                                <div class="mb-2">
                                    <div class="progress" style="height: 25px;">
                                        <div class="progress-bar {{ $event->kuota_terisi >= $event->kuota ? 'bg-danger' : 'bg-success' }}" 
                                             role="progressbar" 
                                             style="width: {{ ($event->kuota_terisi / max($event->kuota, 1)) * 100 }}%">
                                            {{ $event->kuota_terisi }}/{{ $event->kuota }} Peserta
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    @if($event->tanggal_pelaksanaan < now())
                                        <span class="badge bg-secondary">Event Selesai</span>
                                    @else
                                        @if($event->kuota_terisi >= $event->kuota)
                                            <span class="badge bg-danger">Kuota Penuh</span>
                                        @else
                                            <span class="badge bg-success">
                                                Tersisa {{ $event->kuota - $event->kuota_terisi }} kursi
                                            </span>
                                        @endif
                                    @endif
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
                                <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama_event }}" 
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
.progress {
    background-color: #e9ecef;
    border-radius: 0.25rem;
    overflow: hidden;
}

.progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    transition: width 0.6s ease;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 500;
}

.table td, .table th {
    padding: 1rem;
    border-bottom: 1px solid #dee2e6;
}

.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,0.075);
}

.btn {
    margin-left: 0.5rem;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5em 1em;
}
</style>
@endsection 