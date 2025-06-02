<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Artikel - {{ $artikel->judul }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', Arial, sans-serif !important; }
        .main-content { padding-top: 80px; }
        .artikel-card {
            border: none;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .artikel-image-container {
            width: 100%;
            height: 300px;
            overflow: hidden;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .artikel-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .artikel-info { padding: 1.5rem; }
        .artikel-info h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #0835d8;
        }
        .artikel-date {
            font-size: 1rem;
            color: #555;
            margin-bottom: 1rem;
        }
        @media (max-width: 768px) {
            .artikel-image-container { height: 180px; }
            .artikel-info h1 { font-size: 1.5rem; }
        }
        @media (max-width: 500px) {
            .main-content { padding-top: 60px; }
            .artikel-image-container { height: 120px; }
        }
    </style>
</head>
<body>
    {{-- Navbar --}}
    @include('user.navigation-menu')

    <div class="main-content">
        <div class="container py-4">
            <a href="{{ route('user.artikel.index') }}" class="btn btn-outline-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i> Kembali
            </a>

            <div class="artikel-card bg-white">
                {{-- Gambar Artikel --}}
                <div class="artikel-image-container">
                    @if($artikel->gambar)
                        <img src="{{ asset($artikel->gambar) }}" alt="Gambar {{ $artikel->judul }}">
                    @else
                        <div class="text-muted">
                            <i class="fas fa-image fa-3x"></i>
                        </div>
                    @endif
                </div>

                {{-- Detail Artikel --}}
                <div class="artikel-info">
                    <h1 class="mb-3">{{ $artikel->judul }}</h1>
                    <div class="artikel-date mb-3">
                        <i class="fas fa-calendar-alt me-1"></i>
                        {{ \Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('d M Y') }}
                    </div>
                    <hr>
                    <div>
                        {!! $artikel->isi !!}
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
