<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Daftar Artikel</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6, .navbar, .btn, .form-control, .artikel-title, .artikel-date, .artikel-grid, .no-artikels {
            font-family: 'Poppins', Arial, sans-serif !important;
        }
        .main-content { padding-top: 80px; min-height: 100vh; }
        .artikel-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
        }
        .artikel-card {
            background: linear-gradient(145deg, #fff, #f8f9fa);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(3, 53, 216, 0.08);
            border: 1px solid rgba(3, 53, 216, 0.1);
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.3s ease;
        }
        .artikel-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 12px 30px rgba(3, 53, 216, 0.15);
            border-color: rgba(3, 53, 216, 0.2);
        }
        .artikel-image {
            width: 100%;
            height: 180px;
            overflow: hidden;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .artikel-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .artikel-card:hover .artikel-image img {
            transform: scale(1.05);
        }
        .no-image {
            color: #bbb;
            font-size: 2.5rem;
        }
        .artikel-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }
        .artikel-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #0835d8;
            margin-bottom: 0.7rem;
            line-height: 1.4;
        }
        .artikel-date {
            font-size: 0.95rem;
            color: #555;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        .artikel-desc {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1rem;
            flex-grow: 1;
        }
        .btn-detail {
            border-radius: 20px;
            font-weight: 500;
            margin-top: auto;
        }
        .no-artikels {
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
            .artikel-grid { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
        }
        @media (max-width: 768px) {
            .main-content { padding-top: 56px; }
            .page-title h1 { font-size: 2rem; }
            .artikel-grid { gap: 1.5rem; }
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
                <h1>Daftar Artikel</h1>
                <p>Baca artikel menarik seputar origami dan kreativitas lainnya</p>
            </div>
            <div class="artikel-grid">
                @forelse($artikels as $artikel)
                    <div class="artikel-card">
                        <div class="artikel-image">
                            @if($artikel->gambar)
                                <img src="{{ asset($artikel->gambar) }}" alt="Gambar {{ $artikel->judul }}">
                            @else
                                <div class="no-image"><i class="fas fa-image"></i></div>
                            @endif
                        </div>
                        <div class="artikel-content">
                            <div class="artikel-title">{{ $artikel->judul }}</div>
                            <div class="artikel-date"><i class="fas fa-calendar-alt"></i> {{ \Carbon\Carbon::parse($artikel->tanggal_publikasi)->format('d M Y') }}</div>
                            <div class="artikel-desc">{{ Str::limit(strip_tags($artikel->isi), 120) }}</div>
                            <a href="{{ route('user.artikel.show', $artikel->id_artikel) }}" class="btn btn-info btn-detail">
                                <i class="fas fa-book-open"></i> Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="no-artikels">Belum ada artikel untuk ditampilkan.</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('user.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>