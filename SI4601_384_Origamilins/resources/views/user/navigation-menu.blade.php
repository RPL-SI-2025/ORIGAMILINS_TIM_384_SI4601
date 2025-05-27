<nav class="navbar navbar-expand-lg navbar-light fixed-top" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1); font-family:'Poppins',Arial,sans-serif;">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="#">
            <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" width="36" height="36" class="me-2">
            <span style="color:#f9bd1e; font-weight:700; font-size:1.8rem; letter-spacing:0.5px;">Origamilins</span>
        </a>

        {{-- Toggle untuk mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Isi navbar --}}
        <div class="collapse navbar-collapse" id="navbarContent">
            {{-- Menu tengah --}}
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Katalog</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Layanan</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="{{ route('user.event.index') }}">Event</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Kontak</a></li>
            </ul>

            {{-- Search dan Profile kanan --}}
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-link p-0 navbar-icon" type="button">
                    <i class="fas fa-search fs-5"></i>
                </button>
                @auth
                    <button class="btn btn-link position-relative p-0 navbar-icon" type="button">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle">
                            <span class="visually-hidden">New alerts</span>
                        </span>
                    </button>
                    <button class="btn btn-link position-relative p-0 navbar-icon" type="button">
                        <i class="fas fa-shopping-cart fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                           0
                           <span class="visually-hidden">items in cart</span>
                         </span>
                     </button>
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
                    <div class="auth-links">
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
