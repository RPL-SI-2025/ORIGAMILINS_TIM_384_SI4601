<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <!-- Card Manajemen -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="row">

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Manajemen Produk</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ \App\Models\Produk::count() }}</div>
                                        <div class="mt-3">
                                            <a href="{{ route('admin.produk.index') }}" class="btn btn-primary btn-sm">
                                                <i class="fas fa-box me-1"></i> Kelola Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Manajemen Event</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">Total: {{ \App\Models\Event::count() }}</div>
                                        <div class="mt-3">
                                            <a href="{{ route('events.index') }}" class="btn btn-success btn-sm">
                                                <i class="fas fa-calendar me-1"></i> Kelola Event
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </div>
</x-app-layout>

@push('styles')
<style>
    .border-left-primary {
        border-left: 4px solid #4e73df !important;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a !important;
    }
    .text-xs {
        font-size: 0.7rem;
    }
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .btn {
        transition: all 0.2s;
    }
    .btn:hover {
        transform: translateY(-2px);
    }
</style>
@endpush
