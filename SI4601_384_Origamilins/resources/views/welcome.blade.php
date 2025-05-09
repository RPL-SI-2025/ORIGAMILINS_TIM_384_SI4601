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
    <style>
        :root {
            --primary-color: #F9BD1E;
            --secondary-color: #ff8c00;
            --dark-color: #333;
            --light-color: #f9f9f9;
            --accent-color: #4CAF50;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--light-color);
            color: var(--dark-color);
            line-height: 1.6;
            overflow-x: hidden;
        }
        
        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Navigation */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .navbar-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 0;
        }
        
        .logo {
            display: flex;
            align-items: center;
        }
        
        .logo a {
            color: var(--primary-color);    
            font-size: 1.8rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .brand-logo {
            height: 40px;
            margin-right: 10px;
        }
        
        .nav-links {
            display: flex;
            gap: 2rem;
        }
        
        .nav-links a {
            color:  #3FBAD5;
            text-decoration: none;
            font-weight: 500;
            font-size: 1rem;
            transition: color 0.3s;
            position: relative;
        }
        
        .nav-links a:after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: var(--primary-color);
            transition: width 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--primary-color);
        }
        
        .nav-links a:hover:after {
            width: 100%;
        }
        
        .auth-links {
            display: flex;
            gap: 1rem;
        }
        
        .auth-link {
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .login {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
        }
        
        .login:hover {
            background-color: var(--primary-color);
            color: white;
        }
        
        .register {
            background-color: var(--primary-color);
            color: white;
            border: 2px solid var(--primary-color);
        }
        
        .register:hover {
            background-color: transparent;
            color: var(--primary-color);
        }

        .search-auth {
            display: flex;
            align-items: center;
            gap: 1rem;
        }
        .search-box .input-wrapper {
            position: relative;
            margin-right: 16px;
            display: inline-block;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            width: 150px;
            padding: 12px 55px 12px 12px;
            border: 2px solid #ccc;
            border-radius: 999px;
            font-size: 14px;
            outline: none;
        }

        .search-box input::placeholder {
            color: #bbb;
        }

        .search-icon {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hamburger {
            display: none;
            cursor: pointer;
        }
        
        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(255, 140, 0, 0.8), rgba(245, 48, 3, 0.8)), url('/api/placeholder/1200/800') center/cover no-repeat;
            min-height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content {
            color: white;
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding-top: 80px;
            position: relative;
            z-index: 2;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2.5rem;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .btn {
            display: inline-block;
            padding: 15px 30px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            text-transform: uppercase;
            font-size: 1rem;
            letter-spacing: 1px;
        }
        
        .btn-primary {
            background-color: white;
            color: var(--primary-color);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary:hover {
            background-color: transparent;
            color: white;
            box-shadow: 0 4px 20px rgba(255, 255, 255, 0.3);
            border: 2px solid white;
        }
        
        .btn-secondary {
            background-color: transparent;
            color: white;
            border: 2px solid white;
            margin-left: 15px;
        }
        
        .btn-secondary:hover {
            background-color: white;
            color: var(--primary-color);
        }
        
        /* Paper Plane Animation */
        .paper-plane {
            position: absolute;
            animation: fly 15s linear infinite;
            opacity: 0.8;
        }
        
        .paper-plane-1 {
            top: 20%;
            left: -100px;
            animation-delay: 0s;
        }
        
        .paper-plane-2 {
            top: 50%;
            left: -100px;
            animation-delay: 5s;
        }
        
        .paper-plane-3 {
            top: 70%;
            left: -100px;
            animation-delay: 10s;
        }
        
        @keyframes fly {
            0% {
                transform: translateX(0) translateY(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.8;
            }
            90% {
                opacity: 0.8;
            }
            100% {
                transform: translateX(calc(100vw + 100px)) translateY(-100px) rotate(15deg);
                opacity: 0;
            }
        }
        
        /* Feature Section */
        .features {
            padding: 100px 0;
            background-color: white;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }
        
        .section-title h2 {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--dark-color);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2:after {
            content: '';
            position: absolute;
            width: 50px;
            height: 3px;
            background-color: var(--primary-color);
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .section-title p {
            color: #777;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .features-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
        }
        
        .feature-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            padding: 30px;
            width: calc(33.333% - 20px);
            min-width: 300px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }
        
        .feature-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(245, 48, 3, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }
        
        .feature-icon svg {
            color: var(--primary-color);
            width: 40px;
            height: 40px;
        }
        
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 15px;
            color: var(--dark-color);
        }
        
        .feature-card p {
            color: #777;
            margin-bottom: 20px;
        }
        
        .feature-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            margin-top: auto;
        }
        
        .feature-link svg {
            margin-left: 5px;
            transition: transform 0.3s;
        }
        
        .feature-link:hover svg {
            transform: translateX(5px);
        }
        
        /* Gallery Section */
        .gallery {
            padding: 100px 0;
            background-color: var(--light-color);
        }
        
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 50px;
        }
        
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            aspect-ratio: 1/1;
        }
        
        .gallery-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(245, 48, 3, 0.8), rgba(255, 140, 0, 0.8));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.5s;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-item:hover .gallery-img {
            transform: scale(1.1);
        }
        
        .gallery-overlay h3 {
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 0 20px;
        }
        
        /* CTA Section */
        .cta {
            padding: 100px 0;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            text-align: center;
        }
        
        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .cta p {
            font-size: 1.2rem;
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }
        /* Perbedaan Section */
        .perbedaan {
            width: 100vw;
            background-color: #fff;
            padding: 4rem 2rem;
        }

        .perbedaan-content {
            display: flex;
            align-items: center;
            gap: 2rem;
            flex-wrap: wrap;
        }

        .perbedaan-images {
            flex: 1;
            display: flex;
            flex-direction: row;
            gap: 1rem;
        }

        .perbedaan-images img {
            width: calc(33.333% - 0.67rem);
            height: 200px;
            border-radius: 1rem;
        }

        .perbedaan-text {
            flex: 1;
        }

        .perbedaan-text h2 {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .perbedaan-text p {
            margin-bottom: 2rem;
            color: #555;
        }

        .perbedaan-point {
            display: flex;
            align-items: flex-start;
            background: #f9f9f9;
            padding: 1rem;
            border-radius: 0.75rem;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            margin-bottom: 1rem;
            gap: 1rem;
        }

        .event-cards {
            display: flex;
            gap: 1.5rem;
            overflow-x: auto;
            padding: 1rem 0;
            }

            .event-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            width: 250px;
            min-width: 250px;
            flex-shrink: 0;
            padding: 1rem;
            text-align: left;
            }

            .event-card img {
            width: 100%;
            height: 170px;
            border-radius: 0.75rem;
            object-fit: cover;
            margin-bottom: 1rem;
            }

            .event-title {
            font-size: 1rem;
            font-weight: 600;
            color: #000;
            text-decoration: none;
            display: block;
            margin-bottom: 0.5rem;
            transition: color 0.2s ease;
            }

            .event-title:hover {
            color: #f5b300; /* Highlight saat hover */
            }

            .event-date {
            font-size: 0.875rem;
            color: #666;
            }

        .icon-box img {
            width: 100px;
            height: 100px;
        }

        .point-text h3 {
            text-align: left;
            font-size: 1.1rem;
            margin: 0 0 0.5rem 0;
        }

        .point-text p {
            text-align: left;
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }

        .katalog-link {
            display: inline-block;
            margin-top: 1.5rem;
            color: #0077cc;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .katalog-link:hover {
            color: #005fa3;
        }

        /* Footer */
        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 70px 0 20px;
        }
        
        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .footer-logo {
            flex: 1;
            min-width: 200px;
        }
        
        .footer-logo a {
            color: white;
            font-size: 2rem;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        
        .footer-logo p {
            margin-top: 20px;
            color: #ddd;
        }
        
        .footer-links {
            flex: 1;
            min-width: 200px;
        }
        
        .footer-links h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-links h3:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
            bottom: 0;
            left: 0;
        }
        
        .footer-links ul {
            list-style: none;
        }
        
        .footer-links li {
            margin-bottom: 10px;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            transition: color 0.3s;
        }
        
        .footer-links a:hover {
            color: var(--primary-color);
        }
        
        .footer-form {
            flex: 2;
            min-width: 300px;
        }
        
        .footer-form h3 {
            font-size: 1.2rem;
            margin-bottom: 20px;
            position: relative;
            padding-bottom: 10px;
        }
        
        .footer-form h3:after {
            content: '';
            position: absolute;
            width: 40px;
            height: 2px;
            background-color: var(--primary-color);
            bottom: 0;
            left: 0;
        }
        
        .footer-form p {
            color: #ddd;
            margin-bottom: 20px;
        }
        
        .form-group {
            display: flex;
            margin-bottom: 15px;
        }
        
        .form-group input {
            flex: 1;
            padding: 12px 15px;
            border: none;
            border-radius: 30px 0 0 30px;
            font-family: 'Poppins', sans-serif;
        }
        
        .form-group button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0 25px;
            border-radius: 0 30px 30px 0;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        .form-group button:hover {
            background-color: var(--secondary-color);
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-links a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            transition: background-color 0.3s;
        }
        
        .social-links a:hover {
            background-color: var(--primary-color);
        }
        
        .footer-bottom {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            color: #ddd;
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .navbar-content {
                padding: 15px;
            }
            
            .nav-links {
                position: fixed;
                top: 70px;
                left: -100%;
                width: 100%;
                background-color: white;
                flex-direction: column;
                align-items: center;
                padding: 20px 0;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                transition: left 0.3s;
                gap: 1rem;
            }
            
            .nav-links.active {
                left: 0;
            }
            
            .hamburger {
                display: block;
            }
            
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .feature-card {
                width: calc(50% - 20px);
            }
        }
        
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }
            
            .hero p {
                font-size: 1rem;
            }
            
            .btn {
                padding: 12px 25px;
                font-size: 0.9rem;
            }
            
            .feature-card {
                width: 100%;
            }
            
            .gallery-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
            
            .footer-content {
                flex-direction: column;
                gap: 30px;
            }
        }
    </style>
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
