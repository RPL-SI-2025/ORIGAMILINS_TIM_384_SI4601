<nav class="navbar navbar-expand-lg navbar-light bg-light py-3">
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
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Katalog</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Layanan</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Event</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link text-info fw-semibold px-3" href="#">Kontak</a></li>
            </ul>

            {{-- Search dan Profile kanan --}}
            <div class="d-flex align-items-center gap-3">
                {{-- Search Icon --}}
                <button class="btn btn-link p-0" type="button">
                    <i class="fas fa-search fs-5"></i>
                </button>

                {{-- Notification Icon --}}
                <button class="btn btn-link position-relative p-0" type="button">
                    <i class="fas fa-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle p-1 bg-warning border border-light rounded-circle">
                        <span class="visually-hidden">New alerts</span>
                    </span>
                </button>
                <div class="etalase-icons d-flex align-items-center" style="gap:1.5rem;">
                    <div class="position-relative">
                        <a href="/cart">
                        <i class="fas fa-shopping-cart fa-lg text-dark"></i>
                            <span class="badge-cart" id="cart-badge">{{ isset($cartCount) ? $cartCount : 0 }}</span>
                        </a>
                    </div>
                </div>

                {{-- Cart Icon --}}
                {{-- User Info --}}
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('uploads/user.jpg') }}" alt="Profile" class="rounded-circle" width="32" height="32">
                    <span>Customer Dummy</span>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </div>
    </div>
</nav>
