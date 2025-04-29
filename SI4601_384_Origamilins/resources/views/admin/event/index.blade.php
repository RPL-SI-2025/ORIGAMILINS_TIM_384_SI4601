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
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="nama_event" class="form-label small">Nama Event</label>
                                    <input type="text" class="form-control form-control-sm" id="nama_event" name="nama_event" value="{{ request('nama_event') }}" placeholder="Cari nama event...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="mb-2">
                                    <label for="lokasi" class="form-label small">Lokasi</label>
                                    <input type="text" class="form-control form-control-sm" id="lokasi" name="lokasi" value="{{ request('lokasi') }}" placeholder="Cari lokasi...">
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
                                    <label for="status" class="form-label small">Status</label>
                                    <select class="form-select form-select-sm" id="status" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                                        <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Poster</th>
                        <th>Nama Event</th>
                        <th>Tanggal</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($events as $event)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($event->poster)
                                @if(filter_var($event->poster, FILTER_VALIDATE_URL))
                                    <img src="{{ $event->poster }}" alt="Poster {{ $event->nama_event }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                @else
                                    <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama_event }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                                @endif
                            @else
                            <div class="no-image-placeholder">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                            @endif
                        </td>
                        <td>{{ $event->nama_event }}</td>
                        <td>{{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d/m/Y') }}</td>
                        <td>{{ $event->lokasi }}</td>
                        <td>Rp {{ number_format($event->harga, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <span class="badge {{ $event->kuota_terisi >= $event->kuota ? 'bg-danger' : 'bg-success' }}">
                                {{ $event->kuota_terisi }}/{{ $event->kuota }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $event->status === 'tersedia' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $event->getStatusLabel() }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.event.show', $event->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-warning btn-sm" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus event ini?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Tidak ada event</td>
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
}

.no-image-placeholder {
    width: 100px;
    height: 100px;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
}

.no-image-placeholder i {
    font-size: 2rem;
}

.table th {
    background-color: #f8f9fa;
    vertical-align: middle;
}

.table td {
    vertical-align: middle;
}

.btn-group .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border-radius: 0.2rem;
}

.badge {
    font-size: 0.875rem;
    padding: 0.5em 0.75em;
}

.alert {
    margin-bottom: 1rem;
}
</style>
@endsection 