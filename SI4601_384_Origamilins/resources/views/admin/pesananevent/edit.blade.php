@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Pesanan Event</h2>
        <a href="{{ route('admin.pesananevent.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pesananevent.update', $pesanan->id_pesanan_event) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID Pesanan</label>
                            <input type="text" class="form-control" value="{{ $pesanan->id_pesanan_event }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Pesanan</label>
                            <input type="text" class="form-control" value="{{ $pesanan->created_at->format('d/m/Y H:i') }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Pemesan</label>
                            <input type="text" class="form-control" value="{{ $pesanan->nama_pemesan }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Event</label>
                            <input type="text" class="form-control" value="{{ $pesanan->nama_event }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status Pesanan</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}" {{ $pesanan->status == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 