@extends('admin.layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Edit Event</h5>
                </div>

                <div class="card-body">
<<<<<<< HEAD:SI4601_384_Origamilins/resources/views/event/create.blade.php
                    <form action="{{ route('events.store') }}" method="POST">
=======
                    <form action="{{ route('admin.event.update', $event->id) }}" method="POST">
>>>>>>> c8cf72f0e2a873da259f8fec69e694eaedb5bca7:SI4601_384_Origamilins/resources/views/admin/event/edit.blade.php
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="text" class="form-control @error('nama_event') is-invalid @enderror" 
                                id="nama_event" name="nama_event" value="{{ old('nama_event', $event->nama_event) }}" required>
                            @error('nama_event')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $event->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_pelaksanaan" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" class="form-control @error('tanggal_pelaksanaan') is-invalid @enderror" 
                                id="tanggal_pelaksanaan" name="tanggal_pelaksanaan" 
                                value="{{ old('tanggal_pelaksanaan', $event->tanggal_pelaksanaan) }}" required>
                            @error('tanggal_pelaksanaan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                    id="harga" name="harga" value="{{ old('harga', $event->harga) }}" required min="0">
                            </div>
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control @error('lokasi') is-invalid @enderror" 
                                id="lokasi" name="lokasi" value="{{ old('lokasi', $event->lokasi) }}" required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Event
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 