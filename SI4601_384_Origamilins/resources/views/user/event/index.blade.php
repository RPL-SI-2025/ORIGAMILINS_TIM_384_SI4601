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
            padding-top: 70px; /* Lebih rapat ke navbar */
            min-height: 100vh;
        }

        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .event-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex; /* Use flexbox for internal layout */
            flex-direction: column; /* Stack image and content vertically */
            height: 100%;
        }

        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }

        .event-image {
            width: 100%;
            height: 200px; /* Consistent image height */
            overflow: hidden;
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
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #999;
        }

        .event-content {
            padding: 1.5rem;
            flex-grow: 1; /* Allow content to grow */
            display: flex;
            flex-direction: column; /* Stack content elements */
        }

         .event-date, .event-location, .event-quota {
             font-size: 0.95rem;
             color: #666;
             margin-bottom: 0.5rem;
         }

         .event-date i, .event-location i {
             color: #3FBAD5;
             margin-right: 4px;
         }

        .event-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .event-price {
            font-size: 1.1rem;
            font-weight: 700;
            color: #0835d8;
            margin-top: auto; /* Push price to bottom */
             margin-bottom: 0.8rem;
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
        }

        @media (max-width: 768px) {
            .main-content { padding-top: 56px; }
            .page-title h1 { font-size: 2rem; }
            .event-grid { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
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
                <!-- EVENT GRID -->
                <div class="col-lg-12"> {{-- Adjusted column size since no sidebar yet --}}
                    <div class="event-grid">
                         @forelse($events as $event)
                            <div class="event-card">
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
                                    <div class="event-title">{{ $event->nama_event }}</div>
                                    <div class="event-date"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->tanggal)->format('d M Y') }}</div>
                                    <div class="event-location"><i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}</div>
                                    <div class="event-quota">Kuota: {{ $event->kuota }}</div>
                                    <div class="event-price" style="font-size:1.1rem; font-weight:700; color:#0835d8; margin-bottom: 0.8rem;">Harga: Rp {{ number_format($event->harga, 0, ',', '.') }}</div>
                                    <a href="{{ route('user.event.show', $event->id) }}" class="btn btn-primary btn-detail">Lihat Detail</a>
                                </div>
                            </div>
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