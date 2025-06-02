<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - User</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />


    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body { background-color: #f8f9fa; }
        .admin-sidebar { min-height: 100vh; background-color: #fff; padding-top: 2rem; box-shadow: 2px 0 5px rgba(0,0,0,0.05); width: 280px; position: sticky; top: 0; height: 100vh; overflow-y: auto; border-radius: 0 20px 20px 0; margin-right: 15px; }
        .admin-sidebar::-webkit-scrollbar { display: none; }
        .admin-sidebar { -ms-overflow-style: none; scrollbar-width: none; }
        .admin-sidebar .list-group { padding: 0 15px; }
        .admin-sidebar a { color: #6c757d; text-decoration: none; padding: 0.8rem 1rem; display: flex !important; align-items: center; transition: all 0.3s ease; border-radius: 8px; margin-bottom: 5px; border: none; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .admin-sidebar a i { width: 24px; margin-right: 10px; flex-shrink: 0; }
        .admin-sidebar a span { flex: 1; overflow: hidden; text-overflow: ellipsis; }
        .admin-sidebar .list-group-item.active, .admin-sidebar .list-group-item.active:hover { background-color: #0835d8; color: #fff; border-color: #0835d8; }
        .admin-sidebar .list-group-item.active i { color: #fff; }
        .admin-content { padding: 2rem; background-color: #fff; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin: 20px; }
        .admin-header { background-color: #fff; padding: 1rem; box-shadow: 0 2px 4px rgba(0,0,0,0.05); margin-bottom: 20px; }
        .btn-outline-danger { border-color: #dc3545; color: #dc3545; }
        .btn-outline-danger:hover { background-color: #dc3545; color: #fff; }
        .card { border-radius: 10px; border: none; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .card-header { background-color: #fff; border-bottom: 1px solid #eee; padding: 1rem 1.5rem; }
        .form-control { border-radius: 8px; border: 1px solid #ced4da; padding: 0.5rem 1rem; }
        .form-control:focus { border-color: #0835d8; box-shadow: 0 0 0 0.2rem rgba(8, 53, 216, 0.25); }
        .brand-container { display: flex; align-items: center; gap: 12px; }
        .brand-logo { height: 35px; width: auto; }
        .brand-text { margin: 0; color: #0835d8; font-weight: 600; font-size: 1.5rem; }
        @media (max-width: 768px) { .admin-sidebar { position: fixed; left: -280px; z-index: 1040; width: 240px; transition: all 0.3s ease; } .admin-sidebar.show { left: 0; } .admin-content { margin-left: 0 !important; width: 100% !important; } #sidebarToggle { display: block; } }
        @media (min-width: 769px) and (max-width: 1024px) { .admin-sidebar { width: 240px; } }
        #sidebarToggle { display: none; background: none; border: none; font-size: 1.5rem; color: #6c757d; padding: 0.5rem; cursor: pointer; }
    </style>
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
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
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
                <!-- Sidebar User -->
                <div class="col-auto p-0 admin-sidebar">
                    <div class="list-group">
                        <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') && !request()->has('etalase') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a href="{{ route('etalase') }}" class="list-group-item {{ request()->routeIs('etalase') ? 'active' : '' }}">
                            <i class="fas fa-store me-2"></i> Etalase Produk
                        </a>
                        <a href="{{ route('pesananproduk.index') }}" class="list-group-item {{ request()->routeIs('pesananproduk.*') ? 'active' : '' }}">
                            <i class="fas fa-shopping-cart me-2"></i> Pesanan Saya
                        </a>
                        <a href="{{ route('user.payments.history') }}" class="list-group-item {{ request()->routeIs('user.payments.*') ? 'active' : '' }}">
                            <i class="fas fa-history me-2"></i> Riwayat Transaksi
                        </a>
                        <a href="{{ route('profile.create') }}" class="list-group-item">
                            <i class="fas fa-user me-2"></i> Profil
                        @auth
                            <span class="me-3 text-muted">{{ Auth::user()->name }}</span>
                            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm">
                                    <i class="fas fa-sign-out-alt"></i> Logout
                                </button>
                            </form>
                        @endauth
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.admin-sidebar');
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                sidebar.classList.toggle('show');
            });
            document.addEventListener('click', function(e) {
                if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target) && sidebar.classList.contains('show')) {
                    sidebar.classList.remove('show');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html> 