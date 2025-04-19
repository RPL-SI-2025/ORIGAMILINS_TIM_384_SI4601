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
        }
        .admin-sidebar .list-group {
            padding: 0 15px;
        }
        .admin-sidebar a {
            color: #6c757d;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: block;
            transition: all 0.3s ease;
            border-radius: 8px;
            margin-bottom: 5px;
            border: none;
        }
        .admin-sidebar a:hover {
            background-color: #f8f9fa;
            color: #0835d8;
            transform: translateX(5px);
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
        .admin-sidebar .list-group-item.active {
            background-color: #0835d8;
            color: #ffffff;
            border-color: #0835d8;
            transform: translateX(5px);
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
    </style>

    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

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
                            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3 col-lg-2 admin-sidebar">
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
                        <a href="{{ route('admin.artikel.index') }}" class="list-group-item {{ request()->routeIs('admin.artikel.*') ? 'active' : '' }}">
                            <i class="fas fa-newspaper me-2"></i> Manajemen Artikel
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <i class="fas fa-users me-2"></i> Manajemen User
                        </a>
                        <a href="{{ route('admin.event-reviews.index') }}" class="list-group-item {{ request()->routeIs('admin.event-reviews.*') ? 'active' : '' }}">
                            <i class="fas fa-star me-2"></i> Ulasan Event
                        </a>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="col-md-9 col-lg-10">
                    <div class="admin-content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
