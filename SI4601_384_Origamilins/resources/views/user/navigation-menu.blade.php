<nav class="navbar navbar-expand-lg fixed-top" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1); font-family:'Poppins',Arial,sans-serif;">
    <div class="container px-0">
        <div class="navbar-content d-flex w-100 align-items-center justify-content-between">
            {{-- Logo --}}
            <div class="logo d-flex align-items-center">
                <a href="{{ url('/') }}" class="d-flex align-items-center text-decoration-none">
                    <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" class="brand-logo" style="width:36px; height:36px; object-fit:contain; margin-right:10px;">
                    <span style="color:#f9bd1e; font-weight:700; font-size:1.8rem; letter-spacing:0.5px;">Origamilins</span>
                </a>
            </div>
            {{-- Menu --}}
            <div class="nav-links d-flex align-items-center">
                <a href="{{ url('/') }}" class="nav-link px-3">Beranda</a>
                <a href="{{ route('etalase') }}" class="nav-link px-3">Etalase</a>
                <a href="{{ url('/#layanan') }}" class="nav-link px-3">Layanan</a>
                <a href="{{ url('/#event-terdekat') }}" class="nav-link px-3">Event</a>
                <a href="{{ url('/#tentang-kami') }}" class="nav-link px-3">Tentang Kami</a>
                <a href="{{ url('/#kontak') }}" class="nav-link px-3">Kontak</a>
            </div>
            {{-- Icon & Auth --}}
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link p-0 navbar-icon" type="button" style="color:#333;">
                    <i class="fas fa-search fs-5"></i>
                </button>
                <button class="btn btn-link position-relative p-0 navbar-icon" type="button" style="color:#333;">
                    <i class="fas fa-bell fs-5"></i>
                </button>
                <a href="{{ url('/cart') }}" class="btn btn-link position-relative p-0 navbar-icon" style="color:#333;">
                    <i class="fas fa-shopping-cart fs-5"></i>
                </a>
                @auth
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
                    <div class="auth-links d-none d-lg-flex">
                        <a href="{{ route('login') }}" class="auth-link login">Masuk</a>
                        <a href="{{ route('register') }}" class="auth-link register">Daftar</a>
                    </div>
                @endauth
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
