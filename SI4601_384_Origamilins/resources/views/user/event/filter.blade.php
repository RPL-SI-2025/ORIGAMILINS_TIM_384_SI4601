<div class="filter-sidebar">
  <h5 class="mb-3"><i class="fa fa-filter"></i> FILTER EVENT</h5>
  <form method="GET" action="{{ route('user.event.index') }}">
    <div class="mb-3">
      <label for="nama" class="form-label fw-bold mb-2">Nama Event</label>
      <input type="text" class="form-control" id="nama" name="nama" placeholder="Cari nama event..." value="{{ request('nama') }}">
    </div>

    <div class="mb-3">
      <label for="lokasi" class="form-label fw-bold mb-2">Lokasi</label>
      <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Cari lokasi event..." value="{{ request('lokasi') }}">
    </div>

    <hr>

    <div class="mb-3">
      <label class="fw-bold mb-2">Tanggal Pelaksanaan</label>
      <div class="mb-2">
          <label for="tanggal_mulai" class="form-label">Mulai</label>
          <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
      </div>
      <div>
          <label for="tanggal_akhir" class="form-label">Sampai</label>
          <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}">
      </div>
    </div>

    <hr>

    <div class="mb-3">
      <label class="fw-bold mb-2">Rentang Harga</label>
      <div class="input-group mb-2">
        <span class="input-group-text">Rp</span>
        <input type="number" class="form-control" name="harga_min" placeholder="Min" value="{{ request('harga_min') }}">
      </div>
      <div class="input-group">
        <span class="input-group-text">Rp</span>
        <input type="number" class="form-control" name="harga_max" placeholder="Max" value="{{ request('harga_max') }}">
      </div>
    </div>

    <button type="submit" class="btn btn-primary btn-sm mt-2 w-100">Terapkan Filter</button>
    <a href="{{ route('user.event.index') }}" class="btn btn-outline-secondary btn-sm mt-2 w-100">Reset Filter</a>
  </form>
</div>

<style>
.filter-sidebar {
    background: #fff;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
    border-radius: 16px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}
.filter-sidebar h5 {
    font-weight: bold;
    font-size: 1.2rem;
    margin-bottom: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.filter-sidebar hr {
    margin: 1.2rem 0;
    border-color: #eee;
}
.filter-sidebar .form-label {
    font-size: 0.9rem;
    margin-bottom: 0.3rem;
}
.filter-sidebar .form-control {
    font-size: 0.9rem;
}
.filter-sidebar .input-group-text {
     font-size: 0.9rem;
}
.filter-sidebar .btn-primary {
    background: #0835d8; /* Adjust primary color if needed */
    border: none;
    font-weight: 500;
    border-radius: 8px;
}
.filter-sidebar .btn-primary:hover {
    background: #0629a1;
}
.filter-sidebar .btn-outline-secondary {
     border-radius: 8px;
     font-weight: 500;
}
</style> 