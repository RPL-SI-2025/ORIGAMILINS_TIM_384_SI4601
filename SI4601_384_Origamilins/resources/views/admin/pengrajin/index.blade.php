@extends('admin.layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Daftar Pengrajin</h2>
    </div>

    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Pengrajin</h5>
        </div>
        <div class="card-body">
            <form id="filterForm" class="row g-3">
                <div class="col-md-4 mb-3">
                    <label for="nama" class="form-label">Nama Pengrajin</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="{{ request('nama') }}" placeholder="Cari nama pengrajin...">
                </div>
                
                <div class="col-md-4 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ request('email') }}" placeholder="Cari email...">
                </div>

                <div class="col-md-4 mb-3">
                    <label for="status" class="form-label">Status Kegiatan</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Non-aktif</option>
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
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Tanggal Registrasi</th>
                        </tr>
                    </thead>
                    <tbody id="pengrajinTableBody">
                        @include('admin.pengrajin._user_table', ['pengrajin' => $pengrajin])
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
    const pengrajinTableBody = document.getElementById('pengrajinTableBody');
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

    // Function to fetch filtered pengrajin
    function fetchFilteredPengrajin() {
        const formData = new FormData(filterForm);
        const params = new URLSearchParams();
        
        for (const [key, value] of formData.entries()) {
            if (value) params.append(key, value);
        }

        fetch(`{{ route('admin.pengrajin.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            pengrajinTableBody.innerHTML = data.html;
        })
        .catch(error => console.error('Error:', error));
    }

    // Toggle pengrajin status
    window.togglePengrajinStatus = function(pengrajinId) {
        fetch(`{{ url('admin/pengrajin') }}/${pengrajinId}/toggle-status`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchFilteredPengrajin();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Debounced function to prevent too many requests
    window.debouncedFetch = function() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchFilteredPengrajin, 300);
    }

    // Reset filter button
    resetFilter.addEventListener('click', function() {
        filterForm.reset();
        fetchFilteredPengrajin();
        updateURL();
    });

    // Initial fetch if there are URL parameters
    if (window.location.search) {
        fetchFilteredPengrajin();
    }
});
</script>
@endpush
@endsection 