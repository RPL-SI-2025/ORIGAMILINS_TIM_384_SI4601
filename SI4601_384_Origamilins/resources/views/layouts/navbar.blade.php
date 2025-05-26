<!DOCTYPE html>
<nav style="background:#fff; box-shadow:0 2px 8px rgba(0,0,0,0.06); padding:12px 0;">
    <div style="max-width:1200px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; padding:0 24px;">
        <div style="display:flex; align-items:center;">
            <img src="{{ asset('img/logo.png') }}" alt="Logo" style="height:32px; margin-right:8px;">
            <span style="font-weight:700; font-size:1.3rem; color:#F7B500;">Origamilins.</span>
        </div>
        <div style="display:flex; align-items:center; gap:32px;">
            <a href="/" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Beranda</a>
            <a href="/katalog" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Katalog</a>
            <a href="/layanan" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Layanan</a>
            <a href="/event" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Event</a>
            <a href="/tentang-kami" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Tentang Kami</a>
            <a href="/kontak" style="color:#3FBAD5; text-decoration:none; font-weight:500;">Kontak</a>
        </div>
        <div style="display:flex; align-items:center; gap:20px;">
            <a href="#" style="color:#333;"><i class="fa fa-search"></i></a>
            <a href="#" style="color:#333;"><i class="fa fa-bell"></i></a>
            <a href="/cart" style="color:#333; position:relative; text-decoration:none;">
                <i class="fa fa-shopping-cart"></i>
                <span style="position:absolute; top:-8px; right:-12px; background:#e91e63; color:#fff; font-size:0.8rem; font-weight:700; border-radius:12px; padding:2px 7px; min-width:22px; text-align:center; border:2px solid #fff;">{{ isset($cartCount) ? $cartCount : 0 }}</span>
            </a>
            <img src="{{ asset('img/user.png') }}" alt="User" style="height:32px; border-radius:50%;">
            <span style="margin-left:8px; font-weight:500;">Customer Dummy</span>
            <i class="fa fa-chevron-down" style="color:#888; margin-left:4px;"></i>
        </div>
    </div>
</nav>