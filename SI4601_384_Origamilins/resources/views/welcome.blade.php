<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Origamilins - Belanja Bersama Kami</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600|poppins:300,400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container px-0">
            <div class="navbar-content">
                <div class="logo">
                    <a href="#">
                        <img src="{{ asset('uploads/Logo Origamilins.png') }}" alt="Origamilins Logo" class="brand-logo">
                        Origamilins
                    </a>
                </div>
                
                <div class="nav-links">
                    <a href="#">Katalog</a>
                    <a href="#">Layanan</a>
                    <a href="#">Event</a>
                    <a href="#">Tentang Kami</a>
                    <a href="#">Kontak</a>
                </div>  

                <div class="search-auth d-flex align-items-center gap-3">
                <div class="search-box position-relative">
                    <input type="text" placeholder="Cari" class="form-control pe-5">
                    <button type="submit" class="search-icon position-absolute">
                        <svg viewBox="0 0 24 24" width="18" height="18" stroke="gray" stroke-width="2" fill="none">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>

                <div class="auth-links">
                    <a href="javascript:void(0)" class="auth-link login" data-url="{{ route('login') }}">Masuk</a>
                    <a href="javascript:void(0)" class="auth-link register" data-url="{{ route('register') }}">Daftar</a>
                </div>
            </div>

                <script>
                    document.querySelector('.auth-link.login').addEventListener('click', function() {
                        window.location.href = this.dataset.url;
                    });
                    document.querySelector('.auth-link.register').addEventListener('click', function() {
                        window.location.href = this.dataset.url;
                    });
                </script>

                
                <div class="hamburger">
                    <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none">
                        <path d="M3 12h18M3 6h18M3 18h18"></path>
                    </svg>
                </div>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section -->
    <section class="hero">
        <div class="paper-plane paper-plane-1">
            <svg viewBox="0 0 24 24" width="30" height="30" fill="white">
                <path d="M21,4.27L19.73,3L3,19.73L4.27,21L8.46,16.82L9.69,15.58L11.35,13.92L14.99,10.28L21,4.27M5.04,5.93L3.93,4.82L2.81,3.7L3.94,2.57L11.07,9.7L5.04,5.93M19.07,3.93L20.18,5.04L18.93,3.79L17.32,2.18L16.21,3.29L19.07,3.93M21.27,7.73L19.73,9.27L19.07,7.93L21.27,7.73Z" />
            </svg>
        </div>
        <div class="paper-plane paper-plane-2">
            <svg viewBox="0 0 24 24" width="40" height="40" fill="white">
                <path d="M21,4.27L19.73,3L3,19.73L4.27,21L8.46,16.82L9.69,15.58L11.35,13.92L14.99,10.28L21,4.27M5.04,5.93L3.93,4.82L2.81,3.7L3.94,2.57L11.07,9.7L5.04,5.93M19.07,3.93L20.18,5.04L18.93,3.79L17.32,2.18L16.21,3.29L19.07,3.93M21.27,7.73L19.73,9.27L19.07,7.93L21.27,7.73Z" />
            </svg>
        </div>
        <div class="paper-plane paper-plane-3">
            <svg viewBox="0 0 24 24" width="20" height="20" fill="white">
                <path d="M21,4.27L19.73,3L3,19.73L4.27,21L8.46,16.82L9.69,15.58L11.35,13.92L14.99,10.28L21,4.27M5.04,5.93L3.93,4.82L2.81,3.7L3.94,2.57L11.07,9.7L5.04,5.93M19.07,3.93L20.18,5.04L18.93,3.79L17.32,2.18L16.21,3.29L19.07,3.93M21.27,7.73L19.73,9.27L19.07,7.93L21.27,7.73Z" />
            </svg>
        </div>
        
        <div class="container">
            <div class="hero-content">
                <h1>Percayakan Kreasi Terbaik Anda Pada Kami!</h1>
                <p>15+ tahun pengalaman mengajar origami & siap mewujudkan pesanan sesuai keinginan Anda.</p>
                <a href="#" class="btn btn-primary">Lihat Etalase</a>
            </div>
        </div>
    </section>
    
    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Layanan Kami</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17.5,12A1.5,1.5 0 0,1 16,10.5A1.5,1.5 0 0,1 17.5,9A1.5,1.5 0 0,1 19,10.5A1.5,1.5 0 0,1 17.5,12M14.5,8A1.5,1.5 0 0,1 13,6.5A1.5,1.5 0 0,1 14.5,5A1.5,1.5 0 0,1 16,6.5A1.5,1.5 0 0,1 14.5,8M9.5,8A1.5,1.5 0 0,1 8,6.5A1.5,1.5 0 0,1 9.5,5A1.5,1.5 0 0,1 11,6.5A1.5,1.5 0 0,1 9.5,8M6.5,12A1.5,1.5 0 0,1 5,10.5A1.5,1.5 0 0,1 6.5,9A1.5,1.5 0 0,1 8,10.5A1.5,1.5 0 0,1 6.5,12M12,3A9,9 0 0,0 3,12A9,9 0 0,0 12,21A9,9 0 0,0 21,12A9,9 0 0,0 12,3Z" />
                        </svg>
                    </div>
                    <h3>Merchandise & Dekorasi</h3>
                    <p>Kami menghadirkan berbagai kreasi origami eksklusif untuk merchandise dan dekorasi yang unik dan berkelas.</p>

<<<<<<< HEAD
        @if (Route::has('login'))
            <div class="h-14.5 hidden lg:block"></div>
        @endif
    </body>
</html>
=======
                </div>
                
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,3L1,9L12,15L21,10.09V17H23V9M5,13.18V17.18L12,21L19,17.18V13.18L12,17L5,13.18Z" />
                        </svg>
                    </div>
                    <h3>Workshop & Seminar</h3>
                    <p>Origamilins menyediakan layanan workshop dan seminar origami interaktif untuk segala usia.</p>
                </div>

<!-- Perbedaan Section -->
<section class="perbedaan">
<h2>Apa yang berbeda dari <span class="highlight">Kami?</span></h2>
<p>Temukan pengalaman unik dengan origami custom yang kreatif, berkualitas, dan sesuai keinginan Anda!</p>

    <div class="container">
        <div class="perbedaan-content">
            <!-- Left Side Images -->
            <div class="perbedaan-images">
                <img src="{{ asset('uploads/berbeda1.png') }}" alt="Origamilins Logo" class="brand-logo">
                <img src="{{ asset('uploads/berbeda2.png') }}" alt="Origamilins Logo" class="brand-logo">
                <img src="{{ asset('uploads/berbeda3.png') }}" alt="Origamilins Logo" class="brand-logo">
            </div>

            <!-- Right Side Text -->
            <div class="perbedaan-text">
                <div class="perbedaan-point">
                    <div class="icon-box">
                        <img src="{{ asset('uploads/quality.png') }}" alt="Kualitas Terjamin" class="brand-logo">
                    </div>
                    <div class="point-text">
                        <h3>Kualitas Terjamin</h3>
                        <p>Menggunakan teknik terbaik untuk hasil yang indah dan presisi.</p>
                    </div>
                </div>

                <div class="perbedaan-point">
                    <div class="icon-box">
                        <img src="{{ asset('uploads/inovatif.png') }}" alt="Kreatif & Inovatif" class="brand-logo">
                    </div>
                    <div class="point-text">
                        <h3>Kreatif & Inovatif</h3>
                        <p>Dari dekorasi hingga merchandise, kami selalu menghadirkan desain unik.</p>
                    </div>
                </div>

                <div class="perbedaan-point">
                    <div class="icon-box">
                        <img src="{{ asset('uploads/praktik.png') }}" alt="Praktik Langsung & Interaktif" class="brand-logo">
                    </div>
                    <div class="point-text">
                        <h3>Praktik Langsung & Interaktif</h3>
                        <p>Belajar teknik origami dengan metode yang mudah dipahami.</p>
                    </div>
                </div>

                <a href="#" class="katalog-link">Jelajahi Katalog &rarr;</a>
            </div>
        </div>
    </div>
</section>

<!-- Event Terdekat Section -->
<h2>Seminar & Workshop Terdekat!</h2>
<div class="event-cards">
  <div class="event-card">
    <img src="uploads/event1.png" alt="Event 1">
    <a href="/event1.html" class="event-title">Bermain bersama anak melatih kreativitas</a>
    <p class="event-date">17 Juni 2025</p>
  </div>

  <div class="event-card">
    <img src="uploads/event2.png" alt="Event 2">
    <a href="/event2.html" class="event-title">Melipat Origami Bisa Jadi Bisnis Belipat Ganda</a>
    <p class="event-date">29 Juni 2025</p>
  </div>

  <div class="event-card">
    <img src="uploads/event3.png" alt="Event 3">
    <a href="/event3.html" class="event-title">Origami Bercuan, Hidup Berwarna</a>
    <p class="event-date">5 September 2025</p>
  </div>

  <div class="event-card">
    <img src="uploads/event4.png" alt="Event 4">
    <a href="/event4.html" class="event-title">Menghias Kamar Anak Dengan Origami</a>
    <p class="event-date">12 Agustus 2025</p>
  </div>
</div>
>>>>>>> origin/main
