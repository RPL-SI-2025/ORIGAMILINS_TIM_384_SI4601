<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Event</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6, .navbar, .btn, .form-control, .event-title, .event-category, .event-price, .event-quota, .filter-sidebar, .page-title, .pagination, .no-events {
            font-family: 'Poppins', Arial, sans-serif !important;
        }

        .main-content {
            padding-top: 80px; 
            min-height: 100vh;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .event-card {
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(3, 53, 216, 0.08);
            border: 1px solid rgba(3, 53, 216, 0.1);
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 30px rgba(3, 53, 216, 0.15);
            border-color: rgba(3, 53, 216, 0.2);
        }

        .event-image {
            width: 100%;
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .event-image::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: linear-gradient(to top, rgba(0,0,0,0.3), transparent);
            pointer-events: none;
        }

        .event-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .event-card:hover .event-image img {
            transform: scale(1.05);
        }

        .no-image {
            background: linear-gradient(145deg, #f8f9fa, #e9ecef);
            color: #3FBAD5;
        }

        .event-content {
            padding: 1.8rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            background: linear-gradient(145deg, #ffffff, #f8f9fa);
            position: relative;
        }

        .event-content::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(to bottom, #3FBAD5, #0835d8);
            opacity: 0.8;
        }

        .event-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0835d8;
            margin-bottom: 1rem;
            line-height: 1.4;
            padding-left: 0.5rem;
        }

        .event-date, .event-location, .event-quota {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 0.6rem;
            padding-left: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .event-date i, .event-location i {
            color: #0835d8;
            font-size: 1.1rem;
        }

        .event-price {
            font-size: 1.2rem;
            font-weight: 800;
            color: #0835d8;
            margin-top: auto;
            margin-bottom: 0.8rem;
            padding: 0.8rem;
            background: linear-gradient(145deg, rgba(3, 53, 216, 0.05), rgba(63, 186, 213, 0.05));
            border-radius: 12px;
            text-align: center;
        }

        .btn-detail {
            margin-top: 1rem; /* Add margin above button */
            border-radius: 20px;
            font-weight: 500;
        }

        .no-events {
            text-align: center;
            padding: 3rem;
            color: #666;
            font-size: 1.1rem;
            grid-column: 1 / -1;
        }

        .page-title {
            margin-bottom: 2rem;
        }

        .page-title h1 {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .page-title p {
            color: #666;
            font-size: 1.1rem;
        }

        @media (max-width: 992px) {
            .main-content { padding-top: 60px; }
            .event-grid { grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); }
        }

        @media (max-width: 768px) {
            .main-content { padding-top: 56px; }
            .page-title h1 { font-size: 2rem; }
            .event-grid { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('user.navigation-menu')

    <div class="main-content">
        <div class="container">
            <!-- Page Title -->
            <div class="page-title text-center">
                <h1>Daftar Event</h1>
                <p>Temukan dan ikuti berbagai event menarik seputar origami</p>
            </div>
            <div class="row">
                {{-- SIDEBAR FILTER --}}
                <div class="col-lg-3 col-md-4 mb-4">
                    @include('user.event.filter')
                </div>
                <!-- EVENT GRID -->
                <div class="col-lg-9 col-md-8">
                    <div class="event-grid">
                         @forelse($events as $event)
                            <a href="{{ route('user.event.show', $event->id) }}" style="text-decoration:none; color:inherit;">
                                <div class="event-card" style="cursor:pointer;">
                                    @if($event->poster)
                                        <div style="width:100%;height:180px;overflow:hidden;background:#f8f9fa;">
                                            <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama }}" style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                    @else
                                        <div style="width:100%;height:180px;display:flex;align-items:center;justify-content:center;background:#f8f9fa;color:#bbb;">
                                            <i class="fas fa-image fa-3x"></i>
                                        </div>
                                    @endif
                                    <div class="event-content">
                                        <div class="event-title">
                                            {{ $event->nama_event }}
                                        </div>
                                        <div class="event-date"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}</div>
                                        <div class="event-location"><i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}</div>
                                        <div class="event-quota">Kuota: {{ $event->kuota }}</div>
                                        <div class="event-price" style="font-size:1.1rem; font-weight:700; color:#0835d8; margin-bottom: 0.8rem;">
                                            Harga: Rp {{ number_format($event->harga, 0, ',', '.') }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @empty
                            <div class="no-events">Tidak ada event untuk ditampilkan.</div>
                        @endforelse
                    </div>
                     <div class="mt-4">
                        {{-- {{ $events->links() }} --}} {{-- Add pagination if needed --}}
                    </div>
                 </div>
             </div>
         </div>
     </div>

    {{-- Footer --}}
    @include('user.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>