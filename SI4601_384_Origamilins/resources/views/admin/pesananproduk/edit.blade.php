@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Pesanan #{{ $pesanan->id_pesanan }}</h2>
        <a href="{{ route('admin.pesananproduk.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.pesananproduk.update', $pesanan->id_pesanan) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">ID Pesanan</label>
                            <input type="text" class="form-control" value="{{ $pesanan->id_pesanan }}" readonly>
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
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" value="{{ $pesanan->nama_produk }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ekspedisi" class="form-label">Ekspedisi</label>
                            <select class="form-select @error('ekspedisi') is-invalid @enderror" id="ekspedisi" name="ekspedisi">
                                <option value="">Pilih Ekspedisi</option>
                                @foreach(['JNE', 'J&T', 'SiCepat', 'Pos Indonesia', 'TIKI'] as $ekspedisi)
                                    <option value="{{ $ekspedisi }}" {{ $pesanan->ekspedisi == $ekspedisi ? 'selected' : '' }}>
                                        {{ $ekspedisi }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ekspedisi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Pesanan</label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                                <option value="">Pilih Status</option>
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
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 