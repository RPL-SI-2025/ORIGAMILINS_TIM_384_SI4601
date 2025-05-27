<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Etalase Produk</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body { background: #f7f7f7; }
        .etalase-navbar {
            background: #fff;
            box-shadow: 0 2px 8px rgba(8,53,216,0.04);
            padding: 0.75rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .etalase-logo {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .etalase-logo img {
            height: 36px;
        }
        .etalase-search {
            flex: 1;
            max-width: 500px;
            margin: 0 2rem;
        }
        .etalase-search input {
            border-radius: 20px;
            border: 1px solid #e0e0e0;
            padding: 0.5rem 1.5rem;
            width: 100%;
            font-size: 1rem;
        }
        .etalase-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .etalase-user .btn {
            border-radius: 20px;
            font-size: 0.95rem;
        }
        @media (max-width: 768px) {
            .etalase-navbar { flex-direction: column; align-items: stretch; gap: 0.5rem; padding: 0.75rem 1rem; }
            .etalase-search { margin: 0 0 0.5rem 0; max-width: 100%; }
        }
        .badge-cart {
            position: absolute;
            top: -8px;
            right: -12px;
            background: #e91e63;
            color: #fff;
            font-size: 0.8rem;
            font-weight: 700;
            border-radius: 12px;
            padding: 2px 7px;
            min-width: 22px;
            text-align: center;
            border: 2px solid #fff;
            z-index: 2;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="etalase-navbar">
        <div class="etalase-logo">
            <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo">
            <span style="font-weight:700; color:#0835d8; font-size:1.3rem;">Origamilins</span>
        </div>
        <form class="etalase-search" method="get" action="{{ route('etalase') }}">
            <input type="text" name="nama" value="{{ request('nama') }}" placeholder="Cari produk di Origamilins...">
        </form>
        <div class="etalase-icons d-flex align-items-center" style="gap:1.5rem;">
            <div class="position-relative">
                <a href="/cart">
                    <i class="fas fa-shopping-cart fa-lg text-dark"></i>
                    <span class="badge-cart" id="cart-badge">{{ isset($cartCount) ? $cartCount : 0 }}</span>
                </a>
            </div>
            <div class="position-relative">
                <i class="fas fa-bell fa-lg text-dark"></i>
            </div>
        </div>
        <div class="etalase-user">
            <span class="text-muted">{{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" class="btn btn-outline-danger btn-sm">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>
    <main style="min-height:80vh;">
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @stack('scripts')
</body>
</html> 