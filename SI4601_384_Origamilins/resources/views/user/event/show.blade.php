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
            padding-top: 80px;
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
                    {{-- Tombol Daftar Event --}}
<div class="mt-4">
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#daftarEventModal">
        <i class="fas fa-ticket-alt me-2"></i> Daftar Event
    </button>
</div>

<!-- Modal Form Daftar Event -->
<div class="modal fade" id="daftarEventModal" tabindex="-1" aria-labelledby="daftarEventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('user.event.register', $event->id) }}">
        @csrf
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="daftarEventModalLabel">Form Pendaftaran Event</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" id="nama" name="nama" value="{{ Auth::user()->name ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ Auth::user()->email ?? '' }}" required>
            </div>
            <div class="mb-3">
                <label for="telepon" class="form-label">No. Telepon</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
            </div>
            <div class="mb-3">
                <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
                <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" min="1" max="{{ $event->kuota ?? 100 }}" value="1" required>
            </div>
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">Pilih Metode</option>
                    <option value="transfer">Transfer Bank</option>
                    <option value="ewallet">E-Wallet</option>
                    <option value="cod">Bayar di Tempat</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                <textarea class="form-control" id="catatan" name="catatan" rows="2"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Konfirmasi Pendaftaran</button>
          </div>
        </div>
    </form>
  </div>
</div>
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
