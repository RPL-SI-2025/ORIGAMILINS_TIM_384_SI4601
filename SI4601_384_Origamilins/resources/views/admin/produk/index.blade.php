<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium">Daftar Produk</h3>
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">Tambah Produk</a>
                </div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

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
                            <tbody>
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
                                    <td>{{ $product->deskripsi }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="#" class="btn btn-info btn-sm me-2">
                                                <i class="fas fa-eye"></i> View
                                            </a>
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
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="table table-bordered table-striped w-full">
                        <thead>
                            <tr>
                                <th class="px-4 py-2" style="width: 5%">ID</th>
                                <th class="px-4 py-2" style="width: 10%">Gambar</th>
                                <th class="px-4 py-2" style="width: 15%">Nama Produk</th>
                                <th class="px-4 py-2" style="width: 10%">Harga</th>
                                <th class="px-4 py-2" style="width: 10%">Kategori</th>
                                <th class="px-4 py-2" style="width: 30%">Deskripsi</th>
                                <th class="px-4 py-2" style="width: 20%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td class="px-4 py-2">{{ $product->id }}</td>
                                <td class="px-4 py-2">
                                    @if($product->gambar)
                                        @if(filter_var($product->gambar, FILTER_VALIDATE_URL))
                                            <img src="{{ $product->gambar }}" alt="{{ $product->nama }}" class="w-20 h-20 object-cover rounded">
                                        @else
                                            <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-20 h-20 object-cover rounded">
                                        @endif
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $product->nama }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $product->kategori }}</td>
                                <td class="px-4 py-2">{{ $product->deskripsi }}</td>
                                <td class="px-4 py-2">
                                    <div class="flex gap-2 justify-center">
                                        <a href="#" class="px-3 py-1 bg-info text-white rounded hover:bg-info-dark">View</a>
                                        <a href="#" class="px-3 py-1 bg-warning text-white rounded hover:bg-warning-dark">Edit</a>
                                        <form action="#" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1 bg-danger text-white rounded hover:bg-danger-dark" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .table {
            border-collapse: collapse;
            width: 100%;
        }
        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
        }
        .table td, .table th {
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        .bg-info {
            background-color: #0dcaf0;
        }
        .bg-warning {
            background-color: #ffc107;
        }
        .bg-danger {
            background-color: #dc3545;
        }
        .hover\:bg-info-dark:hover {
            background-color: #0b9ec7;
        }
        .hover\:bg-warning-dark:hover {
            background-color: #e0a800;
        }
        .hover\:bg-danger-dark:hover {
            background-color: #bd2130;
        }
        .rounded {
            border-radius: 0.25rem;
        }
        .w-20 {
            width: 5rem;
        }
        .h-20 {
            height: 5rem;
        }
        .object-cover {
            object-fit: cover;
        }
    </style>
</x-app-layout> 