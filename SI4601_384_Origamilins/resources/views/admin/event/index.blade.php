@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mt-4">Daftar Event</h2>
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Event
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header py-2">
                    <h5 class="mb-0">Filter Event</h5>
                </div>
                <div class="card-body py-2">
                    <form action="{{ route('admin.event.index') }}" method="GET">
                        <div class="row g-2">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="nama_event" class="form-label small">Nama Event</label>
                                    <input type="text" class="form-control form-control-sm" id="nama_event" name="nama_event" value="{{ request('nama_event') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="lokasi" class="form-label small">Lokasi</label>
                                    <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi" value="{{ request('lokasi') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tanggal_awal" class="form-label small">Tanggal Awal</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_awal" name="tanggal_awal" value="{{ request('tanggal_awal') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="tanggal_akhir" class="form-label small">Tanggal Akhir</label>
                                    <input type="date" class="form-control form-control-sm" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="harga_min" class="form-label small">Harga Min</label>
                                    <input type="number" class="form-control form-control-sm" id="harga_min" name="harga_min" value="{{ request('harga_min') }}">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label for="harga_max" class="form-label small">Harga Max</label>
                                    <input type="number" class="form-control form-control-sm" id="harga_max" name="harga_max" value="{{ request('harga_max') }}">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-2">
                            <button type="submit" class="btn btn-primary btn-sm">Cari</button>
                            <a href="{{ route('admin.event.index') }}" class="btn btn-secondary btn-sm">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Poster</th>
                        <th>Nama Event</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($event->poster)
                            <img src="{{ url($event->poster) }}" alt="Poster {{ $event->nama_event }}" 
                                 class="img-thumbnail" style="max-width: 100px;">
                            @else
                            <span class="text-muted">Tidak ada poster</span>
                            @endif
                        </td>
                        <td>{{ $event->nama_event }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                        <td>{{ $event->lokasi }}</td>
                        <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                        <td>
                            <a href="{{ route('admin.event.show', $event->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Tidak ada event</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.img-thumbnail {
    border: 1px solid #dee2e6;
    padding: 0.25rem;
    background-color: #fff;
    border-radius: 0.25rem;
    max-height: 100px;
    object-fit: cover;
}

.table th {
    background-color: #f8f9fa;
}

.btn-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.alert {
    margin-bottom: 1rem;
}
</style>
@endsection 