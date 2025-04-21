@extends('admin.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Produk</h2>
        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Produk</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4 mb-3">
                    <label for="nama" class="form-label">Nama Produk</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ request('nama') }}" placeholder="Cari nama produk...">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" id="kategori" name="kategori">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" {{ request('kategori') == $category ? 'selected' : '' }}>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 mb-3">
                    <label for="harga" class="form-label">Harga</label>
                    <select class="form-select" id="harga" name="harga">
                        <option value="">Semua Harga</option>
                        <option value="0-50000" {{ request('harga') == '0-50000' ? 'selected' : '' }}>Dibawah Rp 50.000</option>
                        <option value="50000-100000" {{ request('harga') == '50000-100000' ? 'selected' : '' }}>Rp 50.000 - Rp 100.000</option>
                        <option value="100000-200000" {{ request('harga') == '100000-200000' ? 'selected' : '' }}>Rp 100.000 - Rp 200.000</option>
                        <option value="200000-500000" {{ request('harga') == '200000-500000' ? 'selected' : '' }}>Rp 200.000 - Rp 500.000</option>
                        <option value="500000-1000000" {{ request('harga') == '500000-1000000' ? 'selected' : '' }}>Rp 500.000 - Rp 1.000.000</option>
                        <option value="1000000-0" {{ request('harga') == '1000000-0' ? 'selected' : '' }}>Diatas Rp 1.000.000</option>
                    </select>
                </div>

                <div class="col-12">
                    <button type="button" class="btn btn-primary" onclick="debouncedFetch()">Cari</button>
                    <button type="button" id="resetFilter" class="btn btn-secondary">Reset</button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @foreach($products as $product)
                        <tr>
                            <td>{{ $product->id }}</td>
                            <td>
                                @if($product->gambar)
                                    @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                                        <img src="{{ $product->gambar }}" alt="{{ $product->nama }}" class="img-thumbnail" style="max-width: 100px;">
                                    @else
                                        <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="img-thumbnail" style="max-width: 100px;">
                                    @endif
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>
                            <td>{{ $product->nama }}</td>
                            <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                            <td>{{ $product->kategori }}</td>
                            <td>
                                <span class="badge {{ $product->stok > 0 ? 'bg-success' : 'bg-danger' }}">
                                    {{ $product->stok }}
                                </span>
                            </td>
                            <td>{{ $product->deskripsi }}</td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('admin.produk.edit', $product->id) }}" class="btn btn-warning btn-sm me-2">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('filterForm');
    const resetFilter = document.getElementById('resetFilter');
    const productTableBody = document.getElementById('productTableBody');
    let debounceTimer;

    function updateURL() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }

        const newURL = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newURL);
    }

    function fetchFilteredProducts() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();

        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }

        fetch(`{{ route('admin.produk.index') }}?${params.toString()}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
            productTableBody.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    }

    window.debouncedFetch = function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            updateURL();
            fetchFilteredProducts();
        }, 300);
    }

    resetFilter.addEventListener('click', function() {
        filterForm.reset();
        fetchFilteredProducts();
        updateURL();
    });

    if (window.location.search) {
        fetchFilteredProducts();
    }
});
</script>
@endpush
@endsection
