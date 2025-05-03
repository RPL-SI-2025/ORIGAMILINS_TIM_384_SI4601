<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Admin CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .admin-sidebar {
            min-height: 100vh;
            background-color: #ffffff;
            padding-top: 2rem;
            box-shadow: 2px 0 5px rgba(0,0,0,0.05);
            width: 280px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            border-radius: 0 20px 20px 0;
            margin-right: 15px;
        }
        .admin-sidebar::-webkit-scrollbar {
            display: none;
        }
        .admin-sidebar {
            -ms-overflow-style: none;  
            scrollbar-width: none; 
        }
        .admin-sidebar .list-group {
            padding: 0 15px;
        }
        .admin-sidebar a {
            color: #6c757d;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: flex !important;
            align-items: center;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 5px;
            border: none;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-sidebar a i {
            width: 24px;
            margin-right: 10px;
            flex-shrink: 0;
        }
        .admin-sidebar a span {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .admin-sidebar .list-group-item.active,
        .admin-sidebar .list-group-item.active:hover {
            background-color: #0835d8;
            color: #ffffff;
            border-color: #0835d8;
        }
        .admin-sidebar .list-group-item.active i {
            color: #ffffff;
        }
        .admin-content {
            padding: 2rem;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin: 20px;
        }
        .admin-header {
            background-color: #fff;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        .btn-outline-danger {
            border-color: #dc3545;
            color: #dc3545;
        }
        .btn-outline-danger:hover {
            background-color: #dc3545;
            color: #ffffff;
        }
        .table {
            border-radius: 8px;
            overflow: hidden;
        }
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            color: #495057;
        }
        .card {
            border-radius: 10px;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            padding: 1rem 1.5rem;
        }
        .form-control {
            border-radius: 8px;
            border: 1px solid #ced4da;
            padding: 0.5rem 1rem;
        }
        .form-control:focus {
            border-color: #0835d8;
            box-shadow: 0 0 0 0.2rem rgba(8, 53, 216, 0.25);
        }
        .brand-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brand-logo {
            height: 35px;
            width: auto;
        }
        .brand-text {
            margin: 0;
            color: #0835d8;
            font-weight: 600;
            font-size: 1.5rem;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .admin-sidebar {
                position: fixed;
                left: -280px;
                z-index: 1040;
                width: 240px;
                transition: all 0.3s ease;
            }
            .admin-sidebar.show {
                left: 0;
            }
            .admin-content {
                margin-left: 0 !important;
                width: 100% !important;
            }
            #sidebarToggle {
                display: block;
            }
        }
        
        @media (min-width: 769px) and (max-width: 1024px) {
            .admin-sidebar {
                width: 240px;
            }
        }
        
        /* Toggle button */
        #sidebarToggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #6c757d;
            padding: 0.5rem;
            cursor: pointer;
        }
    </style>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('styles')
</head>
<body>
    <div class="min-h-screen">
        <nav class="admin-header">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="brand-container">
                        <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" class="brand-logo">
                        <h4 class="brand-text">Origamilins</h4>
                    </div>
                    <div>
                        @auth
                            <span class="me-3 text-muted">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @endauth
                        <button id="sidebarToggle" class="d-md-none">
                            <i class="fas fa-bars"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-auto p-0 admin-sidebar">
                    <div class="list-group">
                        <a href="{{ route('admin.dashboard') }}" class="list-group-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('admin.produk.index') }}" class="list-group-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
                            <i class="fas fa-box me-2"></i> Manajemen Produk
                        </a>
                        <a href="{{ route('admin.event.index') }}" class="list-group-item {{ request()->routeIs('admin.event.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar me-2"></i> Manajemen Event
                        </a>
                        <a href="{{ route('admin.pesananproduk.index') }}" class="list-group-item {{ request()->routeIs('admin.pesananproduk.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart me-2"></i> Pesanan Produk
                        </a>
                        <a href="{{ route('admin.product-reviews.index') }}" class="list-group-item {{ request()->routeIs('admin.product-reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star me-2"></i> Ulasan Produk
                        </a>
                        <a href="{{ route('admin.pesananevent.index') }}" class="list-group-item {{ request()->routeIs('admin.pesananevent.*') ? 'active' : '' }}">
                            <i class="fas fa-ticket-alt me-2"></i> Pesanan Event
                        </a>
                        <a href="{{ route('admin.event-reviews.index') }}" class="list-group-item {{ request()->routeIs('admin.event-reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star me-2"></i> Ulasan Event
                        </a>
                        <a href="{{ route('admin.artikel.index') }}" class="list-group-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper me-2"></i> Manajemen Artikel
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Data User
                        </a>
                        <a href="{{ route('admin.pengrajin.index') }}" class="list-group-item {{ request()->routeIs('admin.pengrajin.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Data Pengrajin
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col ps-md-4">
                    <div class="admin-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Helper function for delete confirmations
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }

        // Toggle sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');

            // Toggle sidebar when button is clicked
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
            });

            // Close sidebar when clicking outside
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && 
                    !sidebarToggle.contains(e.target) && 
                    sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
