<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Styles -->
        @livewireStyles
    </head>
    <body class="font-sans antialiased">
        <x-banner />

        <div class="min-h-screen bg-gray-100">
            @livewire('navigation-menu')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                        <a class="cart-icon position-relative" href="/cart" title="Keranjang Saya" style="float: right; margin-top: -30px; font-size: 1.2rem;">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="badge-cart" id="cart-badge">{{ isset($cartCount) ? $cartCount : 0 }}</span>
                            Keranjang
                        <a class="cart-icon" href="/user/cart" title="Keranjang Saya" style="float: right; margin-top: -30px; font-size: 1.2rem;">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </a>
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>

        @stack('modals')

        @livewireScripts

        <style>
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
    </body>
</html>
