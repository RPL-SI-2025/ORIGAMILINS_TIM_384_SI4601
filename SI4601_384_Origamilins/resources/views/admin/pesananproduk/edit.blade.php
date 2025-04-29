@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Pesanan Produk</h2>
        <a href="{{ route('admin.pesananproduk.index') }}" class="btn btn-secondary">
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
                            <input type="text" class="form-control" value="{{ $pesanan->user->name }}" readonly>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" value="{{ $pesanan->produk->nama_produk }}">
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="ekspedisi" class="form-label">Ekspedisi</label>
                            <select class="form-select @error('ekspedisi') is-invalid @enderror" id="ekspedisi" name="ekspedisi">
                                @foreach($ekspedisiOptions as $value => $label)
                                    <option value="{{ $value }}" {{ $pesanan->ekspedisi == $value ? 'selected' : '' }}>
                                        {{ $label }}
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

                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="pengrajin_id" class="form-label">Assign ke Pengrajin</label>
                            <select class="form-select @error('pengrajin_id') is-invalid @enderror" id="pengrajin_id" name="pengrajin_id">
                                <option value="">-- Pilih Pengrajin --</option>
                                @foreach($pengrajinList as $pengrajin)
                                    <option value="{{ $pengrajin->id }}" {{ $pesanan->pengrajin_id == $pengrajin->id ? 'selected' : '' }}>
                                        {{ $pengrajin->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pengrajin_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                @if($pesanan->status == 'Siap Dikirim')
                <div class="row mb-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="nomor_resi" class="form-label">Nomor Resi Pengiriman</label>
                            <input type="text" class="form-control @error('nomor_resi') is-invalid @enderror" id="nomor_resi" name="nomor_resi" value="{{ old('nomor_resi', $pesanan->nomor_resi) }}" required>
                            @error('nomor_resi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                @endif

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