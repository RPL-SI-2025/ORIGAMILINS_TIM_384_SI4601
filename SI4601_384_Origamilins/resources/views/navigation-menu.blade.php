<nav class="navbar navbar-expand-lg navbar-light" style="background:#fff; box-shadow:0 2px 10px rgba(0,0,0,0.1); font-family:'Poppins',Arial,sans-serif; position:fixed; width:100%; top:0; z-index:1000;">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand d-flex align-items-center fw-bold" href="{{ url('/') }}">
            <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" width="28" height="36" class="me-2">
            <span style="color:#f9bd1e; font-weight:700; font-size:1.8rem; letter-spacing:0.5px;">Origamilins</span>
        </a>

        {{-- Toggle untuk mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Isi navbar --}}
        <div class="collapse navbar-collapse" id="navbarContent">
            {{-- Menu tengah --}}
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ route('home') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ route('etalase') }}">Etalase</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ url('/#layanan') }}">Layanan</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ route('user.event.index') }}">Event</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ route('user.artikel.index') }}">Artikel</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ url('/#tentang-kami') }}">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-medium px-3" href="{{ url('/#faq') }}">FAQ</a></li>
            </ul>

            {{-- Ikon Kanan (Search, Notifikasi, Cart, User) --}}
            <div class="d-flex align-items-center gap-3">

                <!-- Notification Dropdown -->
                <div class="dropdown">
                    <a class="btn btn-link position-relative p-0 navbar-icon icon-bell" href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell fs-5"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount" style="font-size: 0.6rem; padding: 0.3em 0.6em; transform: translate(50%, -50%);">
                        {{$notifBelumDibuka}}
                            <span class="visually-hidden">unread notifications</span>
                        </span>
                    </a>
                    
                    <!-- Dropdown Menu -->
                    <ul class="dropdown-menu dropdown-menu-end p-0" aria-labelledby="notificationDropdown" style="width: 320px; border-radius: 8px;">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                            <h6 class="mb-0">Notifikasi</h6>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content" id="notificationTabsContent">
                            <!-- Transaksi Tab Content -->
                            <div class="tab-pane fade show active" id="transaksi" role="tabpanel" aria-labelledby="transaksi-tab">
                                <div id="notificationItems" style="max-height: 300px; overflow-y: auto;">
                                  @if($notifikasi->count() > 0)
        @foreach($notifikasi as $notif)
            {{-- <a href="{{ route('user.pesanan.show', $notif->id) }}" class="dropdown-item d-flex justify-content-between align-items-start"> --}}
                {{-- set href untuk redirect ke halaman detail pesanan --}}
                <a href="{{ route('pesanan.show', ['id_pesanan' => $notif->id_pesanan]) }}" class="dropdown-item d-flex justify-content-between align-items-start">

                <div>
                    <strong>Status:</strong> {{ ucfirst($notif->status) }}<br>
                    <small class="text-muted">Pesanan ID: {{ $notif->id_pesanan }}</small>
                </div>
                <small class="text-muted">{{ \Carbon\Carbon::parse($notif->updated_at)->diffForHumans() }}</small>
                    </a>
        @endforeach
        @else
            <div class="dropdown-item text-center text-muted py-3">Tidak ada notifikasi baru.</div>
        @endif
                                </div>
                            </div>
                        </div>
                        
                    </ul>
                </div>

                <!-- Cart -->
                <a href="{{ url('/cart') }}" class="btn btn-link position-relative p-0 navbar-icon icon-cart" aria-label="Keranjang">
                    <i class="fas fa-shopping-cart fs-5"></i>
                </a>

                <!-- User -->
                @auth
                    <div class="dropdown">
                        <a class="d-flex align-items-center gap-2 text-decoration-none dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo_url ?? asset('uploads/user.jpg') }}" alt="Profile" class="rounded-circle" width="32" height="32">
                            <span class="text-dark">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-user me-2"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('user.pesanan.index') }}">
                                    <i class="fas fa-box me-2"></i> Pesanan Saya
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('user.payments.history') }}">
                                    <i class="fas fa-receipt me-2"></i>  Riwayat Transaksi
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                                    </button>
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
