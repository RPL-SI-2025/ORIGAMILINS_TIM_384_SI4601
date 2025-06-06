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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        @stack('scripts')

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

        /* Styles for Notification Dropdown */
        .dropdown-menu {
            max-height: 400px;
            overflow-y: auto;
            /* Adjustments for footer link colors */
            .dropdown-footer-link {
                color: #3FBAD5 !important; /* Origamilins blue */
            }
        }
        .badge.bg-danger {
            position: absolute;
            /* Adjusted position */
            top: 0px; 
            right: 0px;
            transform: translate(50%, -50%); /* Center relative to corner */
            padding: .25em .4em;
            font-size: .75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .375rem;
            border: 1px solid white; /* Optional: add a white border like in the example */
        }
         .notification-icon-container {
             position: relative;
             cursor: pointer;
         }
        </style>
    </body>
</html>
