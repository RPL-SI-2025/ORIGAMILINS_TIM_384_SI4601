<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Event - {{ $event->nama_event }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif !important;
        }

        .main-content {
            padding-top: 70px;
            min-height: 100vh;
        }

        .event-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .event-image-container {
            width: 100%;
            height: 300px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .event-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .event-info {
            padding: 1.5rem;
        }

        .event-info h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0835d8;
        }

        .event-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0835d8;
        }

        @media (max-width: 768px) {
            .event-image-container {
                height: 200px;
            }

            .event-info h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 500px) {
            .main-content {
                padding-top: 60px;
            }

            .event-image-container {
                height: 160px;
            }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('user.navigation-menu')

    <div class="main-content">
        <div class="container py-4">
            <a href="{{ route('user.event.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>

            <div class="event-card bg-white">
                {{-- Poster Full Width --}}
                <div class="event-image-container">
                    @if($event->poster)
                        <img src="{{ asset($event->poster) }}" alt="Poster {{ $event->nama_event }}">
                    @else
                        <div class="text-muted">
                            <i class="fas fa-image fa-3x"></i>
                        </div>
                    @endif
                </div>

                {{-- Detail Event --}}
                <div class="event-info">
                    <h1 class="mb-3">{{ $event->nama_event }}</h1>

                    <div class="mb-3">
                        <span class="event-price">Rp {{ number_format($event->harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="mb-3 d-flex align-items-center gap-2 flex-wrap">
                        <span class="badge bg-primary">Event</span>
                        @if($event->kuota !== null)
                            <span class="badge bg-warning text-dark">Kuota: {{ $event->kuota }}</span>
                        @endif
                    </div>

                    <div class="mb-3 text-muted">
                        <i class="fas fa-calendar-alt me-1"></i> {{ \Carbon\Carbon::parse($event->tanggal_pelaksanaan)->format('d M Y') }}<br>
                        <i class="fas fa-map-marker-alt me-1"></i> {{ $event->lokasi }}
                    </div>

                    <hr>

                    <div>
                        <strong>Deskripsi Event:</strong>
                        <p class="text-muted mt-2">{!! nl2br(e($event->deskripsi)) !!}</p>
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
