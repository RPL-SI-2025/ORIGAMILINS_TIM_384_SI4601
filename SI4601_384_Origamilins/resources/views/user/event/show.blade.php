<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <title>Detail Event</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; color: #333; margin: 20px; }
        .event-poster-container { width: 100%; height: 340px; overflow: hidden; background: #f8f9fa; margin-bottom: 1.5rem; border-radius: 1rem; display: flex; align-items: center; justify-content: center; }
        .event-poster-container img { width: 100%; height: 100%; object-fit: cover; border-radius: 1rem; }
        .shadow-sm { box-shadow: 0 2px 8px rgba(8,53,216,0.06) !important; }
        .btn-back { margin-bottom: 1.5rem; border-radius: 20px; }
        @media (max-width: 768px) { .event-poster-container { height: 200px; } }
    </style>
</head>
<body>
    @include('user.navigation-menu')
    <div class="container py-4">
        <a href="{{ route('user.event.index') }}" class="btn btn-outline-secondary btn-back"><i class="fas fa-arrow-left me-2"></i></a>
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="bg-white rounded-4 p-4 d-flex flex-column align-items-center shadow-sm">
                    @if($event->poster)
                        <div class="event-poster-container">
                            <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama_event }}">
                        </div>
                    @else
                        <div class="event-poster-container" style="color:#bbb;">
                            <i class="fas fa-image fa-4x"></i>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-lg-6">
                <div class="bg-white rounded-4 p-4 h-100 d-flex flex-column justify-content-between shadow-sm">
                    <div>
                        <h1 class="fw-bold mb-2" style="color:#0835d8; font-size:2rem;">{{ $event->nama_event }}</h1>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <span class="fs-5 fw-bold text-success">Harga: Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <span class="badge bg-primary">Event</span>
                            @if($event->kuota !== null)
                                <span class="badge bg-warning text-dark">Kuota: {{ $event->kuota }}</span>
                            @endif
                        </div>
                        <div class="mb-2 d-flex align-items-center gap-2">
                            <span class="text-muted"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}</span>
                            <span class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ $event->lokasi }}</span>
                        </div>
                        <hr class="my-3">
                        <div class="mb-3">
                            <strong>Deskripsi Event:</strong>
                            <div class="text-muted">{!! nl2br(e($event->deskripsi)) !!}</div>
                        </div>
                    </div>
                    {{-- Tombol aksi bisa ditambah di sini --}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html> 