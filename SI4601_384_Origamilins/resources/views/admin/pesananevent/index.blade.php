@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Manajemen Pesanan Event</h2>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Pesanan</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pesananevent.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Pesanan</label>
                    <input type="text" class="form-control" id="search" name="search" 
                           value="{{ request('search') }}" placeholder="Cari nama pemesan, event, atau ID pesanan...">
                </div>
                
                <div class="col-md-4">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ request('status') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label for="date_range" class="form-label">Rentang Tanggal</label>
                    <div class="input-group">
                        <input type="date" class="form-control" name="date_start" value="{{ request('date_start') }}">
                        <span class="input-group-text">sampai</span>
                        <input type="date" class="form-control" name="date_end" value="{{ request('date_end') }}">
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Cari</button>
                    <a href="{{ route('admin.pesananevent.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Nama Pemesan</th>
                            <th>Event</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $item)
                            <tr>
                                <td>{{ $item->id_pesanan_event }}</td>
                                <td>{{ $item->nama_pemesan }}</td>
                                <td>{{ $item->nama_event }}</td>
                                <td>
                                    <span class="badge 
                                        @if($item->status === 'Menunggu') bg-warning
                                        @elseif($item->status === 'Belum Berjalan') bg-info
                                        @elseif($item->status === 'Sedang Berjalan') bg-primary
                                        @elseif($item->status === 'Selesai') bg-success
                                        @else bg-danger
                                        @endif">
                                        {{ $item->status }}
                                    </span>
                                </td>
                                <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.pesananevent.edit', $item->id_pesanan_event) }}" 
                                           class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pesanan</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 