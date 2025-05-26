<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            margin: 20px;
        }
        .event-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .event-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }
        .event-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
        }
        .event-content {
            padding: 1.5rem;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
        }
        .event-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
            line-height: 1.4;
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
        .event-desc {
            margin-bottom: 1rem;
            color: #444;
            font-size: 0.98rem;
        }
        .event-quota {
            font-weight: 600;
            color: #ff6b35;
        }
        .btn-detail {
            margin-top: auto;
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
        @media (max-width: 768px) {
            .event-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    @include('user.navigation-menu')
    <div class="container py-4">
        <div class="event-grid">
            @forelse($events as $event)
            <div class="event-card">
                @if($event->poster)
                    <div style="width:100%;height:180px;overflow:hidden;background:#f8f9fa;">
                        <img src="{{ $event->poster }}" alt="Poster {{ $event->nama }}" style="width:100%;height:100%;object-fit:cover;">
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
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>