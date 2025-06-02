<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Form Pendaftaran Event - {{ $event->nama_event }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    @include('user.navigation-menu')

    <div class="container py-4">
        <a href="{{ route('user.event.show', $event->id) }}" class="btn btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Detail Event
        </a>
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Form Pendaftaran Event: {{ $event->nama_event }}</h5>
            </div>
            <div class="card-body">
                <form id="midtrans-form" method="POST" action="{{ route('user.event.register', $event->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', Auth::user()->name ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah_tiket" class="form-label">Jumlah Tiket</label>
                        <input type="number" class="form-control" id="jumlah_tiket" name="jumlah_tiket" min="1" max="{{ $event->kuota ?? 100 }}" value="{{ old('jumlah_tiket', 1) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                            <option value="">Pilih Metode</option>
                            <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="ewallet" {{ old('metode_pembayaran') == 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan Tambahan (Opsional)</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="2">{{ old('catatan') }}</textarea>
                    </div>
                    <button type="button" id="pay-button" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i> Daftar & Bayar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Midtrans Snap JS --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script>
    document.getElementById('pay-button').onclick = function(e) {
        e.preventDefault();
        let form = document.getElementById('midtrans-form');
        let formData = new FormData(form);

        fetch("{{ route('user.event.register', $event->id) }}", {
            method: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if(data.snap_token){
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result){
                        window.location.href = data.redirect_url;
                    },
                    onPending: function(result){
                        window.location.href = data.redirect_url;
                    },
                    onError: function(result){
                        alert('Pembayaran gagal!');
                    }
                });
            } else if(data.errors) {
                alert('Validasi gagal. Pastikan data sudah benar.');
            }
        });
    };
    </script>
    @include('user.footer')
</body>
</html>