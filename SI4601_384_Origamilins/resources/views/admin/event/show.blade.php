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
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if($event->poster)
                        <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama_event }}" 
                             class="img-fluid rounded mb-3" style="max-height: 300px;">
                    @else
                        <div class="text-muted">Tidak ada poster</div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 200px;">Nama Event</th>
                            <td>{{ $event->nama_event }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal Pelaksanaan</th>
                            <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d F Y') }}</td>
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
                            <td>{{ $event->deskripsi }}</td>
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
.table th {
    font-weight: 600;
    color: #333;
}

.card {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.img-fluid {
    object-fit: contain;
}
</style>
@endsection 