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
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="productTableBody">
                        @include('admin.produk._product_table', ['products' => $products])
                    </tbody>
                </table>
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

    // Function to update filters in URL without reloading page
    function updateURL() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }
        
        const newURL = window.location.pathname + (params.toString() ? '?' + params.toString() : '');
        window.history.pushState({}, '', newURL);
    }

    // Function to fetch filtered products
    function fetchFilteredProducts() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }

        fetch(`{{ route('admin.produk.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            productTableBody.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    }

    // Debounced function to prevent too many requests
    window.debouncedFetch = function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchFilteredProducts, 300);
    }

    // Reset filter button
    resetFilter.addEventListener('click', function() {
        filterForm.reset();
        fetchFilteredProducts();
        updateURL();
    });

    // Initial fetch if there are URL parameters
    if (window.location.search) {
        fetchFilteredProducts();
    }
});
</script>
@endpush
@endsection 