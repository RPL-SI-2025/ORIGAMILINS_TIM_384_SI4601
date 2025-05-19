@extends('admin.layouts.app')

@section('content')
<div class="container">
    <h2>Edit Pengrajin</h2>
    <form action="{{ route('admin.pengrajin.pengrajin.update', $pengrajin->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Pengrajin</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pengrajin->nama) }}" required>
            @error('nama')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Pengrajin</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pengrajin->email) }}" required>
            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="is_active" class="form-label">Status</label>
            <select name="is_active" id="is_active" class="form-control" required>
                <option value="1" {{ old('is_active', $pengrajin->is_active) == '1' ? 'selected' : '' }}>Aktif</option>
                <option value="0" {{ old('is_active', $pengrajin->is_active) == '0' ? 'selected' : '' }}>Non-aktif</option>
            </select>
            @error('is_active')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.pengrajin.pengrajin.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection