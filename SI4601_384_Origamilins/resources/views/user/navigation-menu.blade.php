<nav class="navbar navbar-expand-lg navbar-light bg-light py-3 fixed-top">
    <div class="container-fluid">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold text-warning" href="#">
            <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" width="30" height="30" class="me-2">
            Origamilins
        </a>

        {{-- Toggle untuk mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Isi navbar --}}
        <div class="collapse navbar-collapse" id="navbarContent">
            {{-- Menu tengah --}}
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="{{ route('dashboard') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="{{ route('etalase') }}">Katalog</a></li>
                {{-- Links below will only work correctly if included on the welcome page --}}
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="/welcome#layanan">Layanan</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="/welcome#event-terdekat">Event</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="/welcome#tentang-kami">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="/welcome#kontak">Kontak</a></li>
            </ul>

            {{-- Search dan Profile kanan --}}
            <div class="d-flex align-items-center gap-3">
                {{-- Search Icon --}}
                <button class="btn btn-link p-0" type="button">
                    <i class="fas fa-search fs-5"></i>
                </button>

                @auth
                    {{-- Notification Icon --}}
                    <button class="btn btn-link position-relative p-0" type="button">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </button>

                    {{-- Cart Icon (Example, assuming you have a cart) --}}
                     <button class="btn btn-link position-relative p-0" type="button">
                        <i class="fas fa-shopping-cart fs-5"></i>
                         {{-- You might add a badge here for item count --}}
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                           0 {{-- Replace with actual cart item count --}}
                           <span class="visually-hidden">items in cart</span>
                         </span>
                     </button>

                    {{-- User Info --}}
                    <div class="dropdown">
                        <a class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('uploads/user.jpg') }}" alt="Profile" class="rounded-circle" width="32" height="32">
                            <span class="text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                             <li><a class="dropdown-item" href="{{ route('profile.show') }}"><i class="fas fa-user me-2"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                     <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    {{-- Auth Links (Login/Register) --}}
                    <div class="auth-links">
                         <a href="{{ route('login') }}" class="auth-link login">Masuk</a>
                         <a href="{{ route('register') }}" class="auth-link register">Daftar</a>
                     </div>
                 @endauth

            </div>
             {{-- Hamburger menu for mobile --}}
            <div class="hamburger d-block d-lg-none">
                <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none">
                    <path d="M3 12h18M3 6h18M3 18h18"></path>
                </svg>
            </div>
        </div>
    </div>
</nav>

{{-- Add this script for handling auth links if they are needed somewhere else --}}
{{-- Note: With full page navigation, this might not be necessary here anymore --}}
{{-- <script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.auth-link.login').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.dataset.url || this.href;
        });
    });
    document.querySelectorAll('.auth-link.register').forEach(link => {
         link.addEventListener('click', function(e) {
            e.preventDefault();
            window.location.href = this.dataset.url || this.href;
        });
    });
});
</script> --}}
